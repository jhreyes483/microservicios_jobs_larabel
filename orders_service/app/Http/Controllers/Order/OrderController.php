<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Helpers\ClientHttp;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
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
    )
    {
        $this->utilitiesOrders        = $utilitiesOrders;
        $this->auth                   = $auth;
    }


    /**
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
            $found = false;
            while (!$found) {
                $platters = Recipe::limit(10)->orderBy('retry')->limit(3)->get()->toArray();
                $platters = $this->utilitiesOrders->randomPlate($platters);

                if ($platters && isset($platters['id'])) {
                    $login = $this->auth->toLoginWarehouseService();

                    if (!$login['status']) return ['status' => false, 'msg' => 'error de autenticacion w', 'code' => 500];

                    $recipe = Recipe::with('Ingredients')->where('recipes.id', $platters['id'])->get()->toArray();

                    if (isset($recipe[0]) &&  $recipe[0]['ingredients']) {
                        $d = ['ingredients' => $recipe[0]['ingredients']];
                        $resp = $this->sendHttp(
                            $this->getUrlWarehouseService()['warehouseIngredientMass'],
                            ['ingredients' => $recipe[0]['ingredients']],
                            'POST',
                            $login['data']['authorisation']
                        );



                        if ($resp['status']) {
                            $order = new Order();
                            $order->status_id = 1;
                            $order->user_id  = Auth::id();
                            $order->recipe_id = $recipe[0]['id'];
                            $order->save();
                            DB::commit();
                            return ['status' => true, 'msg' => 'Se creo la order con id ' . $order->id, 'order_id' => $order->id, 'code' => 200];
                            $found = true;
                        }
                    }
                }
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $output['msg'] = ' error->' . $th->getMessage() . ' line->' . $th->getLine() . ' file->' . $th->getFile();
            $output['code'] = 500;
            return $output;
        }
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
}
