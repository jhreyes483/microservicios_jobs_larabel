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
}
