<?php

namespace App\Http\Controllers\Ingredient;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Ingredient\IngredientInventory;
use App\Models\InventoryMovement;
use App\Models\TypeOfMovement;
use App\Models\ReasonOfMovement;

class IngredientController extends Controller
{
    private $inventory;

    public function __construct(
        IngredientInventory $inventory
    ) {
        $this->inventory = $inventory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $outputs['status'] = true;
        $outputs['msg'] = 'ok';


        $movements = InventoryMovement::with('Type')->with('Reazon')->with('Ingredient');
        if($request->movement_type_id){
            $movements->where('movement_type_id',$request->movement_type_id );
        }
        if($request->movement_reason_id){
            $movements->where('movement_reason_id',$request->movement_reason_id );
        }
        if($request->movement_ingredient_id){
            $movements->where('ingredient_id',$request->movement_ingredient_id );
        }
        
        
        $movements = $movements->orderBy('id', 'desc')->get()->toArray();
        $outputs['movements'] = $movements;
        if (!$movements) {
            $outputs['status'] = true;
            $outputs['msg'] = 'No hay movimientos';
            $outputs['movements'] = [];
        }
        return $outputs;
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

        if (true) {
            $outputs['status'] = true;
            $outputs['msg'] = 'peticion ok';
        }
        return $outputs;
        //
    }

    public function getIngredientsMass(Request $request)
    {
        $outputs['status'] = false;
        $outputs['msg'] = 'error';

        if (isset($request['ingredients']) && count($request['ingredients'])) {
            $outputs['status'] = true;
            $outputs['msg'] = 'peticion okddda';
            $outputs['process'] = [];

            $allIngredintFull = true;

            foreach ($request['ingredients'] as $ingredient) {
                $resp = $this->inventory->consumerProdunct($ingredient);
                if (!$resp['status']) {
                    $allIngredintFull = false;
                    $outputs['msg']  = $resp['msg'] . ' ' . $ingredient['name'] ?? 'no identificado';
                } else {
                    $resp['ingredient'] = $ingredient;
                    $outputs['process'][] = $resp;
                }
            }

            if (!$allIngredintFull) {
                $outputs['status'] = false;
            }
        }
        return $outputs;
        //
    }

    public function getComplements()
    {
        $types = TypeOfMovement::select('id', 'name')->get();
        $reasons = ReasonOfMovement::select('id', 'name')->get();
        $ingredient = Ingredient::select('id', 'name')->get();
        return [ 'status'=>true, 'data'=> ['types' =>  $types, 'reasons'=>$reasons, 'ingredient'=>$ingredient]] ;
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

        if (true) {
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
