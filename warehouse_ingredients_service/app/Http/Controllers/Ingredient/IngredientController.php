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
use App\Models\Job;

class IngredientController extends Controller
{
    private $inventory;

    public function __construct(
        IngredientInventory $inventory
    ) {
        $this->inventory = $inventory;
    }


    public function purchaseIndex(Request $request)
    {
        $output['status'] = true;
        $output['code'] = 200;
        $output['msg'] = 'ok';

        try {
            $purchases =  Job::with('Type')->with('Status')->with('Model')
                        ->where('job_type_id', $this->typeJobPurchase);
            $page      = $request->input('page', 1);
            $purchases = $purchases->orderBy('jobs.id', 'desc');
            $purchases = $purchases->paginate(10, ['*'], 'page', $page);
            $output['purchases'] = $purchases;

        } catch (\Throwable $th) {
            $output['msg'] = ' error->' . $th->getMessage() . ' line->' . $th->getLine() . ' file->' . $th->getFile();
            $output['code'] = 500;
        }
        return $output;
    }

    public function index(Request $request): array
    {
        $output['status'] = true;
        $output['code'] = 200;
        $output['msg'] = 'ok';

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
            $output['movements'] = $movements;
            if (!$movements) {
                $output['status'] = true;
                $output['msg'] = 'No hay movimientos';
                $output['movements'] = [];
            }
        } catch (\Throwable $th) {
            $output['msg'] = ' error->' . $th->getMessage() . ' line->' . $th->getLine() . ' file->' . $th->getFile();
            $output['code'] = 500;
        }
        return $output;
    }

    public function getIngredientsMass(Request $request): array
    {
        $output['status'] = false;
        $output['msg'] = 'error';
        $output['code'] = 400;
        try {
            DB::beginTransaction();
            if (isset($request['ingredients']) && count($request['ingredients'])) {
                $output['status'] = true;
                $output['code'] = 200;
                $output['msg'] = 'peticion ok...';
                $output['process'] = [];

                $allIngredintFull = true;

                foreach ($request['ingredients'] as $ingredient) {
                    $resp = $this->inventory->consumerProdunct($ingredient, $request['external_order_id']??null );
                    if (!$resp['status']) {
                        $allIngredintFull = false;
                        $output['msg']  = $resp['msg'] . ' ' . $ingredient['name'] ?? 'no identificado';
                        $output['pendings'][] = $ingredient;
                    } else {
                        $resp['ingredient'] = $ingredient;
                        $output['process'][] = $resp;
                    }
                }

                if (!$allIngredintFull) {
                    $output['status'] = false;
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $output['msg'] = ' error->' . $th->getMessage() . ' line->' . $th->getLine() . ' file->' . $th->getFile();
            $output['code'] = 500;
        }
        return $output;
    }

    public function getComplements(): array
    {
        $types = TypeOfMovement::select('id', 'name')->get();
        $reasons = ReasonOfMovement::select('id', 'name')->get();
        $ingredient = Ingredient::select('id', 'name')->get();
        return ['status' => true, 'data' => ['types' =>  $types, 'reasons' => $reasons, 'ingredient' => $ingredient, 'code' => 200]];
    }
}
