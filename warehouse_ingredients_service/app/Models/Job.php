<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    public function Type(){
        return $this->belongsTo(JobType::class, 'job_type_id' );
    }

    public function Status(){
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function Model(){
        return $this->belongsTo(Ingredient::class, 'model_id');
    }

}
