<?php

namespace App\Http\Controllers;

use App\Models\InventoryMovement;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{

    public function create($modelId, $jobTypeId, $quantity,$externalOderId )
    {
        $output['status'] = true;
        $output['msg'] = 'Ya se habia hagendado otra compra para este modelo';
      
        $jobIsAlreadyScheduled = Job::where('model_id', $modelId)
            ->where('job_type_id', $jobTypeId)
            ->where('status_id', 4)
            ->where('external_order_id',$externalOderId )
            ->first();
    

        if (!$jobIsAlreadyScheduled) {
            $output['msg'] = 'Se crea tarea de compra';
            $job = new Job();
            $job->modeL_id  = $modelId;
            $job->retry     = 0;
            $job->status_id = 4; /* pendiente */
            $job->job_type_id = $jobTypeId;
            $job->model_quantity = $quantity;
            $job->external_order_id = $externalOderId;
            $job->save();
        }
        return $output;
    }


}
