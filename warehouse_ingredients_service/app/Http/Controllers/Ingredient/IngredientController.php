<?php

namespace App\Http\Controllers\Ingredient;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Ingredient\IngredientInventory;
use App\Models\InventoryMovement;
use App\Models\TypeOfMovement;
use Illuminate\Support\Facades\DB;

use App\Models\ReasonOfMovement;

class IngredientController extends Controller
{
    private $inventory;

    public function __construct(
        IngredientInventory $inventory
    ) {
        $this->inventory = $inventory;
    }

    public function index(Request $request): array
    {
        $outputs['status'] = true;
        $output['code'] = 200;
        $outputs['msg'] = 'ok';

        try {
            $movements = InventoryMovement::with('Type')->with('Reazon')->with('Ingredient');
            if ($request->movement_type_id) {
                $movements->where('movement_type_id', $request->movement_type_id);
            }
            if ($request->movement_reason_id) {
                $movements->where('movement_reason_id', $request->movement_reason_id);
            }
            if ($request->movement_ingredient_id) {
                $movements->where('ingredient_id', $request->movement_ingredient_id);
            }


            $movements = $movements->orderBy('id', 'desc');
 
            $page      = $request->input('page', 1);
            $movements = $movements->paginate(10, ['*'], 'page', $page);
            $outputs['movements'] = $movements;
            if (!$movements) {
                $outputs['status'] = true;
                $outputs['msg'] = 'No hay movimientos';
                $outputs['movements'] = [];
            }
        } catch (\Throwable $th) {
            $output['msg'] = ' error->' . $th->getMessage() . ' line->' . $th->getLine() . ' file->' . $th->getFile();
            $output['code'] = 500;
        }
        return $outputs;
    }

    public function getIngredientsMass(Request $request): array
    {
        $outputs['status'] = false;
        $outputs['msg'] = 'error';
        $outputs['code'] = 400;
        try {
            DB::beginTransaction();
            if (isset($request['ingredients']) && count($request['ingredients'])) {
                $outputs['status'] = true;
                $outputs['code'] = 200;
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
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $output['msg'] = ' error->' . $th->getMessage() . ' line->' . $th->getLine() . ' file->' . $th->getFile();
            $output['code'] = 500;
        }
        return $outputs;
    }

    public function getComplements(): array
    {
        $types = TypeOfMovement::select('id', 'name')->get();
        $reasons = ReasonOfMovement::select('id', 'name')->get();
        $ingredient = Ingredient::select('id', 'name')->get();
        return ['status' => true, 'data' => ['types' =>  $types, 'reasons' => $reasons, 'ingredient' => $ingredient, 'code' => 200]];
    }
}
