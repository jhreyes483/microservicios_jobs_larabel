<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
  protected $table = 'inventory_movements';
  protected $fillable = [];
  public $timestamps = true;
  protected $primaryKey = 'id';
  use HasFactory;

  public function Type()
  {
     return $this->belongsTo(TypeOfMovement::class, 'movement_type_id');
  }

  public function Reazon()
  {
     return $this->belongsTo(ReasonOfMovement::class, 'movement_reason_id');
  }

  public function Ingredient()
  {
     return $this->belongsTo(Ingredient::class, 'ingredient_id');
  }




}
