<?php


namespace App\Http\Controllers\Ingredient;

use App\Http\Controllers\JobController;
use App\Http\Helpers\ClientHttp;
use App\Http\Helpers\InventoryMovementLog;
use App\Models\Ingredient;

use function PHPUnit\Framework\returnSelf;

class IngredientInventory
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


    public function consumerProdunct($ingredientIn)
    {
        $output['status'] = false;
        $output['msg'] = 'no se modifico inventario, no existe producto';

        $ingredient = Ingredient::where('name', $ingredientIn['name'])->first();
        if ($ingredient) {
            if ($ingredient->quantity - $ingredientIn['quantity'] <=  0) {
                $response = $this->buyIngredient($ingredientIn, $ingredient);#
                if ($response['status']) {
                    $this->movementInvetory($ingredient->id, $ingredientIn['quantity'], 2 /* resta */, 3 /* entra de producto */);
                    $output['status'] = true;
                    $output['msg'] = 'se comproducto y se despacho producto';
                }else{
                    $jobResponse =  $this->job->create( $ingredient->id, 1 );
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


    public function buyIngredient($ingredientIn)
    {
        $login = $this->toLoginBuyService();
        if (!$login['status']) return ['status' => false, 'msg' => 'error de autenticacion w'];
        $resp = $this->sendHttp(
            $this->getBuyUrlService()['buyIngredient'],
            ['ingredient' => $ingredientIn['name'], 'quentity' => $ingredientIn['quantity']],
            'POST',
            $login
        );
       
        if (!$resp['status']) return ['status' => false, 'msg' => 'error en respuesta http'];
        if (!isset($resp['data']['quanitySold'])) return ['status' => false, 'msg' => 'no se retorno quanitySold de market'];
        if($resp['data']['quanitySold'] == 0) return ['status'=>false, 'msg', 'No hay existencias en plaza', 'quanitySold'=> $resp['data']['quanitySold'] ];

        $quantityBuy          = ((int) $resp['data']['quanitySold']) ?? 0;

        if ($quantityBuy > 0) {
            $log = $this->movementInvetory($ingredientIn['id'], $quantityBuy, 1 /* suma */, 2 /* compra inmediata */);
        }
        $ingredient           = Ingredient::where('name', $ingredientIn['name'])->first();
        return ['status' => 'ok', 'msg' => 'se realizo la compra', 'quantity' => $ingredient->quantity, 'ingredient' => $ingredientIn['name']];
    }
}
