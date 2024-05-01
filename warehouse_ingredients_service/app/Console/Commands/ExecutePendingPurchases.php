<?php

namespace App\Console\Commands;

use App\Http\Controllers\Ingredient\IngredientInventory;
use App\Http\Controllers\JobController;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExecutePendingPurchases extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'excute:pending_purchases';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecuta las compras de ingredientes pendientes';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public $inventory;
    public function __construct(
        IngredientInventory $inventory 
    )
    {
        parent::__construct();
        $this->inventory = $inventory;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $reps =  $this->inventory->buyJobIngredient();
        $this->info('(INI)excute:pending_purchases' .Carbon::now()->toDateTimeString());
        $this->info('status->'.$reps['status']);
        $this->info('msg->'.$reps['msg']);
        $this->info('(END)excute:pending_purchases '.Carbon::now()->toDateTimeString());
     
        return ['status'=>true, 'msg'=> 'comando ejecutado' ];
    }
}
