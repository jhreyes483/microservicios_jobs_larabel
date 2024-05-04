<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;


class IngredientController extends Controller
{
    public $quantityBuyDefault = 10;

    /**
     * @param Request $request
     * @return array
     */
    public function buy(Request  $request): array
    {
        $output['status'] = true;
        $output['code'] = 200;
        $output['msg'] = 'ok';
        $output['quantitySold'] = 0;
        try {

            $validate = $this->validateRequest($request, [
                'ingredient'       => 'required|string',
            ]);
            if($validate['error']) return ['status'=>false, 'msg'=>$validate['msg'], 'code'=>400];

            $ingredient = Ingredient::where('name', strtolower($request->ingredient))->first();


            if(isset($request->but_quantity)){
                $quantity =  $ingredient->quantity - $request->but_quantity;
                $quantity = $quantity < 0 ? 0 : $quantity;
                $ingredient->quantity = $quantity;
                $output['quantitySold'] = $request->but_quantity > $ingredient->quantity ? $ingredient->quantity : $request->but_quantity;
                $ingredient->save();
            }


            $quantity =  $ingredient->quantity - $this->quantityBuyDefault;
            $quantity = $quantity < 0 ? 0 : $quantity;
            $output['quantitySold'] = $this->quantityBuyDefault > $ingredient->quantity ? $ingredient->quantity :$this->quantityBuyDefault;
            $ingredient->quantity = $quantity;
            $ingredient->save();

            $output['quantitySold'] = $output['quantitySold']  < 0 ? 0 : $output['quantitySold'];

        } catch (\Throwable $th) {
            $output['msg'] = ' error->' . $th->getMessage() . ' line->' . $th->getLine() . ' file->' . $th->getFile();
            $output['code'] = 500;
        }
        if($output['quantitySold'] == 0) $output['msg'] = 'No hay existencias';
        return $output;

    }

    /**
     * @param Request $request
     * @return array
     */
    public function get(Request  $request): array
    {
        $output['status'] = true;
        $output['code'] = 200;
        $output['msg'] = 'ok';
        try {
            $page        = $request->input('page', 1);
            $ingredient =  Ingredient::orderBy('id', 'desc');
            $ingredient = $ingredient->paginate(10, ['*'], 'page', $page);
            $output['ingredients'] =  $ingredient;

        } catch (\Throwable $th) {
            $output['msg'] = ' error->' . $th->getMessage() . ' line->' . $th->getLine() . ' file->' . $th->getFile();
            $output['code'] = 500;
        }
        return $output;

    }

    public function update(Request $request)
    {
        $output['status'] = true;
        $output['code'] = 200;
        $output['msg'] = 'actualizo ingredintes';
        try {
            if(count($request->update)){
                foreach ($request->update as $ingredientIn){
                    $ingredient = Ingredient::where('id',  $ingredientIn['id'])->first();
                    $ingredient->quantity = $ingredientIn['quantity'];
                    $ingredient->save();
                }
            }else{
                $output['no hay ingredientes'];
            }
        } catch (\Throwable $th) {
            $output['msg'] = ' error->' . $th->getMessage() . ' line->' . $th->getLine() . ' file->' . $th->getFile();
            $output['code'] = 500;
        }
        return $output;
    }
}
