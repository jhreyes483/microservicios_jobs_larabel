<?php

namespace App\Http\Controllers\Ingredient;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Ingredient\IngredientInventory;

class IngredientController extends Controller
{
    private $inventory;

    public function __construct(
        IngredientInventory $inventory
    )
    {
        $this->inventory = $inventory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $outputs['status'] = false;
        $outputs['msg'] = 'error';
        
        if(true){
            $outputs['status'] = true;
            $outputs['msg'] = 'peticion ok';
        }
        return $outputs;
        //
    }

    public function getIngredientsMass(Request $request){
        $outputs['status'] = false;
        $outputs['msg'] = 'error';
        
        if(isset($request['ingredients']) && count($request['ingredients']) ){
            $outputs['status'] = true;
            $outputs['msg'] = 'peticion okddda';
            $outputs['process'] = [];

            $allIngredintFull = true;

            foreach($request['ingredients'] as $ingredient){
                $resp = $this->inventory->consumerProdunct($ingredient);
                if(!$resp['status']){
                    $allIngredintFull = false; 
                    $outputs['msg']  = $resp['msg'].' '.$ingredient['name']??'no identificado';
                }else{
                    $resp['ingredient'] = $ingredient;
                    $outputs['process'][] = $resp;
                }  
            }

            if(!$allIngredintFull){
                $outputs['status'] = false;
            }
        }
        return $outputs;
        //
    }

    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function show(Ingredient $ingredient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function edit(Ingredient $ingredient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ingredient $ingredient)
    {
        $outputs['status'] = false;
        $outputs['msg'] = 'error';
        
        if(true){
            $outputs['status'] = true;
            $outputs['msg'] = 'peticion ok update';
        }
        return $outputs;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ingredient $ingredient)
    {
        //
    }
}
