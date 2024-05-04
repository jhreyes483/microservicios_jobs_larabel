<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Helpers\ClientHttp;
use App\Models\ConfigService;

use App\Models\Order;
use App\Models\Recipe;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{

    use ClientHttp;

    /**
     * @var UtilitiesOrders
     */
    private $utilitiesOrders;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $urlWarehouseService;

    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */



    public function __construct(
        UtilitiesOrders $utilitiesOrders,
        AuthController $auth
    ) {
        $this->utilitiesOrders        = $utilitiesOrders;
        $this->auth                   = $auth;
    }


    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request): array
    {
        $output['status'] =  true;
        $output['msg']    = 'ok';
        $output['code']   = 200;

        try {
            $page = $request->input('page', 1);

            $order = Order::with(['Recipe.Ingredients' =>
            function ($query) {
                $query->withPivot('recipe_quantity');
            }])
                ->with('Status')
                ->orderBy('id', 'desc')
                ->paginate(9, ['*'], 'page', $page);
            $output['order']   =  $order;
            if (!$order) {
                $output['status'] =  false;
                $output['msg']    = 'no existe orden';
            }
        } catch (\Throwable $th) {
            $output['msg'] = ' error->' . $th->getMessage() . ' line->' . $th->getLine() . ' file->' . $th->getFile();
            $output['code'] = 500;
        }

        return $output;
    }


    /**
     * @param Request $request
     * @return array
     */
    public function store(Request $request): array
    {
        $output['status'] =  true;
        $output['msg']    = 'ok';
        $output['code']   = 200;
        try {
            DB::beginTransaction();
            $config = ConfigService::where('active', true)->first();
            switch ($config->id) {
                case 1:
                    $output = $this->createOrderIngredientIsset();
                    break;
                case 2:
                    $output = $this->createOrderIngredientAll();
                    break;
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $output['msg'] = ' error->' . $th->getMessage() . ' line->' . $th->getLine() . ' file->' . $th->getFile();
            $output['code'] = 500;
            return $output;
        }
        DB::commit();
        return $output;
    }


    /**
     * @param Order $order
     * @return array
     */
    public function show(Order $order): array
    {
        $output['status'] =  true;
        $output['msg']    = 'ok';
        $output['code']   = 200;
        try {
            $order = Order::where('id', $order->id)
                ->with(['Recipe.Ingredients' =>
                function ($query) {
                    $query->withPivot('recipe_quantity');
                }])
                ->with('Status')
                ->first();
            $output['order']   =  $order;
            if (!$order) {
                $output['status'] =  false;
                $output['msg']    = 'no existe orden';
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $output['msg'] = ' error->' . $th->getMessage() . ' line->' . $th->getLine() . ' file->' . $th->getFile();
            $output['code'] = 500;
            return $output;
        }
        return $output;
    }

    /**
     * @return array
     */
    private function createOrderIngredientIsset() : array
    {
        $output['status'] =  true;
        $output['msg']    = 'ok';
        $output['code']   = 200;
        $found = false;
        while (!$found) {
            $platters = Recipe::orderBy('retry')->limit(3)->get()->toArray();
            $platters = $this->utilitiesOrders->randomPlate($platters);

            if ($platters && isset($platters['id'])) {
                $login = $this->auth->toLoginWarehouseService();

                if (!$login['data']['status'] ?? false &&  $login['data']['status'] != "success"  ) return ['status' => false, 'msg' => 'error de autenticacion w..', 'code' => 500];

                $recipe = Recipe::with('Ingredients')->where('recipes.id', $platters['id'])->get()->toArray();

                if (isset($recipe[0]) &&  $recipe[0]['ingredients']) {

                    $resp = $this->sendHttp(
                        $this->getUrlWarehouseService()['warehouseIngredientMass'],
                        ['ingredients' => $recipe[0]['ingredients']],
                        'POST',
                        $login['data']['authorisation']
                    );
                    $status = $resp['status']['data']['status']??false;

                    if ($status) {
                        $order = new Order();
                        $order->status_id = $this->statusEnd;
                        $order->user_id  = Auth::id();
                        $order->recipe_id = $recipe[0]['id'];
                        $order->missing_ingredients_ids = json_encode([]);
                        $order->save();
                        return ['status' => true, 'msg' => 'Se creo la order con id ' . $order->id, 'order_id' => $order->id, 'code' => 200];
                        $found = true;
                    }
                }
            }
        }
        return $output;
    }

    private function createOrderIngredientAll(): array
    {
        $output['status'] =  true;
        $output['msg']    = 'ok';
        $output['code']   = 200;
        $pendingsIds      = [];
        $typeOrder        = 'success';

        $countRecipe      = Recipe::orderBy('retry')->count();
        $idRecipe         = rand(1, $countRecipe);
        $recipe           = Recipe::with('Ingredients')->where('recipes.id', $idRecipe )->first()->toArray();

        if ($recipe && isset($recipe['id'])) {
            $login = $this->auth->toLoginWarehouseService();
            if (! ($login['data']['status'] ?? false) &&  $login['data']['status'] != "success"  ) return ['status' => false, 'msg' => 'error de autenticacion w..', 'code' => 500];

            $order            = new Order();
            $order->status_id = $this->statusPending;
            $order->user_id   = Auth::id();
            $order->recipe_id = $recipe['id'];
            $order->save();

            if(isset($recipe['ingredients']) && count($recipe['ingredients'])) {
                $resp = $this->sendHttp(
                    $this->getUrlWarehouseService()['warehouseIngredientMass'],
                    ['ingredients' => $recipe['ingredients'], 'external_order_id' => $order->id ],
                    'POST',
                    $login['data']['authorisation']
                );

                $status = $resp['status']['data']['status']??false;
                if(!$status && isset($resp['data']['pendings'])  && count($resp['data']['pendings'])  ){
                    $typeOrder    = 'partial';
                    foreach ($resp['data']['pendings'] as $ingredient) $pendingsIds[]  = $ingredient['id'];
                }
                $pendingsIds =array_unique($pendingsIds);
            }

            $order->missing_ingredients_ids = json_encode( $pendingsIds  );
            $order->status_id               = count($pendingsIds) ? $this->statusPending : $this->statusEnd;
            $order->save();

            return ['status' => true, 'msg' => 'Se creo la order con id ' . $order->id, 'order_id' => $order->id, 'code' => 200, 'typeOder'=>$typeOrder];
        }
        return $output;
    }

    public function receiveIngredient(Request $request): array
    {
        $output['status'] =  true;
        $output['msg']    = 'ok';
        $output['code']   = 200;
        if($request->ingredient_id && $request->external_order_id){

            $order                = Order::where('id', $request->external_order_id)->first();

            $ingredientPendingIds = array_unique(json_decode($order->missing_ingredients_ids));

            $id = $request->ingredient_id;
            $ingredientPendingIds = array_values( array_filter( $ingredientPendingIds, function($value) use ( $id ) {
                return $value !== $id;
            }));


            $order->missing_ingredients_ids = json_encode($ingredientPendingIds );
            $order->status_id = count($ingredientPendingIds) ? $this->statusPending : $this->statusEnd;
            $order->save();
        }

        return $output;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getStatus(Request $request): array
    {
         $statuses = Status::whereIn('id' , $request->status_ids)->get();
         return ['statuses'=>$statuses];
    }

}
