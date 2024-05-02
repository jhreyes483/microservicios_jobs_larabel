<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeOfMovement extends Model
{
    protected $table = 'type_of_movements';
    protected $fillable = [];
    public $timestamps = true;
    protected $primaryKey = 'id';
    use HasFactory;

    public function Movements(){
        return $this->hasMany(InventoryMovement::class, 'movement_type_id' );
    }
}
