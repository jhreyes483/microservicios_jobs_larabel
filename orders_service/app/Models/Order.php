<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function Recipe()
    {
       return $this->belongsTo(Recipe::class, 'recipe_id');
    }

    public function Status(){
        return $this->belongsTo(Status::class, 'status_id');
    }



}
