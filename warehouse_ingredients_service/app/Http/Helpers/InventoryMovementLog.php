<?php

namespace App\Http\Helpers;

use App\Models\Ingredient;
use App\Models\InventoryMovement;
use Illuminate\Support\Facades\Auth;

trait  InventoryMovementLog
{
    public function logInventory($ingredientId, $quantity, $typeId, $reasonId, $ingredient)
    {
        $output['status'] = false;
        $movement = new InventoryMovement();
        $movement->movement_reason_id = $reasonId;
        $movement->movement_type_id = $typeId;

        switch ($typeId) {
            case 1:
                $quantity =  $ingredient->quantity + $quantity;
                $movement->quantity = $quantity;
                break;

            case 2:
                $quantity =  $ingredient->quantity - $quantity;
                $quantity =  $quantity < 0 ? 0 : $quantity;
                $movement->quantity = $quantity;
                break;
        }
        if ($movement) {
            $movement->ingredient_id = $ingredientId;
            if (Auth::id()) {
                $movement->user_id = Auth::id();
            }

            $movement->save();
            $output['status'] = true;
            $output['quantity'] = $movement->quantity;
        }
    }

    public function movementInvetory($ingredientId, $quantity, $typeId, $reasonId)
    {
        $ingredient =  Ingredient::where('id', $ingredientId)->first();
        $this->logInventory($ingredientId, $quantity, $typeId, $reasonId,  $ingredient);
        switch ($typeId) {
            case 1:
                $quantity =  $ingredient->quantity + $quantity;
                $ingredient->quantity = $quantity;
                break;
            case 2:
                $quantity =  $ingredient->quantity - $quantity;
                $quantity =  $quantity < 0 ? 0 : $quantity;
                $ingredient->quantity = $quantity;
                break;
        }
        $ingredient->save();
        $output['status'] = true;
        $output['quantity'] = $ingredient->quantity;


        return $output;
    }
}
