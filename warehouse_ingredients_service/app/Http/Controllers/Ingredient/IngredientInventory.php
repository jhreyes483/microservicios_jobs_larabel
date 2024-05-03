<?php


namespace App\Http\Controllers\Ingredient;

use App\Http\Controllers\Controller;
use App\Http\Controllers\JobController;
use App\Http\Helpers\ClientHttp;
use App\Http\Helpers\InventoryMovementLog;
use App\Models\Ingredient;
use App\Models\Job;

use function PHPUnit\Framework\returnSelf;

class IngredientInventory extends Controller
{
    use InventoryMovementLog;
    use ClientHttp;

    private $ingredientBuyUp;
    private $job;

    public function __construct(
        JobController  $job
    ){
        $this->job = $job;

    }


    public function consumerProdunct($ingredientIn, $externalOrderId = null): array
    {
        $output['status'] = false;
        $output['msg'] = 'no se modifico inventario, no existe producto';

        $ingredient = Ingredient::where('name', $ingredientIn['name'])->first();
        if ($ingredient) {
            $ingredientIn['quantity'] = $ingredientIn['pivot']['recipe_quantity']; /** se debe descontar lo de la receta no lo que tiene el producto en cocina */
            if ($ingredient->quantity - $ingredientIn['quantity'] <=  0) {

                $response = $this->buyIngredient($ingredientIn, $ingredient);#
                if ($response['status']) {
                    $this->movementInvetory($ingredient->id, $ingredientIn['quantity'], 2 /* resta */, 3 /* entra de producto */);
                    $output['status'] = true;
                    $output['msg'] = 'se comproducto y se despacho producto';
                }else{
                    $jobResponse =  $this->job->create( $ingredient->id, 1 , $ingredientIn['quantity'], $externalOrderId );
                    $output['msg'] = 'no hay existencia de producto en plaza, se agenda futura compra';
                }
            } else {
                $this->movementInvetory($ingredient->id, $ingredientIn['quantity'], 2 /* resta */, 3 /* entra de producto */);
                $output['status'] = true;
                $output['msg'] = 'se consumio producto de bodega';
            }
        } 

        return $output;
    }


    public function buyIngredient($ingredientIn, $isJob = false): array
    {
        $login = $this->toLoginBuyService($isJob);

        if (!$login['status']) return ['status' => false, 'msg' => 'error de autenticacion w'];

        $resp = $this->sendHttp(
            $this->getBuyUrlService()['buyIngredient'],
            ['ingredient' => $ingredientIn['name'], 'quentity' => $ingredientIn['quantity']],
            'POST',
            $login
        );
        $this->saveHttpLog(['ingredient' => $ingredientIn['name']], $resp, 1, $resp['status'] , $this->getBuyUrlService()['buyIngredient']);

        if (!$resp['status']) return ['status' => false, 'msg' => 'error en respuesta http'];
        if (!isset($resp['data']['quanitySold'])) return ['status' => false, 'msg' => 'no se retorno quanitySold de market'];
        if($resp['data']['quanitySold'] == 0) return ['status'=>false, 'msg', 'No hay existencias en plaza', 'quanitySold'=> $resp['data']['quanitySold'] ];

        $quantityBuy          = ((int) $resp['data']['quanitySold']) ?? 0;

        if ($quantityBuy > 0) {
            $reasonId = $isJob ? 1 /* compra por espera */: 2 /* compra inmediata */ ;
            $log = $this->movementInvetory($ingredientIn['id'], $quantityBuy, 1 /* suma */,$reasonId);
        }
        $ingredient           = Ingredient::where('name', $ingredientIn['name'])->first();
        return ['status' => 'ok', 'msg' => 'se realizo la compra', 'quantity' => $ingredient->quantity, 'ingredient' => $ingredientIn['name']];
    }


    public function buyJobIngredient(): array
    {
        $output['status'] = true;
        $output['msg'] = 'no hay pendientes';
        $jobsPending = Job::where('job_type_id', 1 )
        ->where('status_id', $this->statusRending )
        ->limit(10)
        ->orderBy('retry','asc')
        ->get();

        if (count($jobsPending)){
            foreach($jobsPending as $job){
                
                $ingredientIn = Ingredient::where('id', $job->model_id )->first()->toArray();
                $resp = $this->buyIngredient($ingredientIn  , true);

                if($resp['status']){
                    $job->status_id = $this->statusEnd;

                    $login = $this->toLoginOrderService(true);
                    $body  = ['ingredient_id'=>$job->model_id,'external_order_id'=>$job->external_order_id ];

                    $resp = $this->sendHttp(
                        $this->getUrlOrderService()['receiveIngredient'],
                        $body,
                        'POST',
                        $login
                    );
                    $this->saveHttpLog($body, $resp, 1, $resp['status'] , $this->getBuyUrlService()['buyIngredient']);


                }else{
                    $job->status_id = $this->statusRending;
                    $job->retry ++;
                }
                $job->save();
          
     
            }

            $output['msg'] = 'se ejecutaron todos los pendiente';
        
        }
        return $output;
    }
}
