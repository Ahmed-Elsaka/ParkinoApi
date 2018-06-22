<?php

namespace App\Console\Commands;
use App\Http\Controllers;
use App\MakeReservation;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class HourlyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hour:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check reserved users balance every hour';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(User $user)
    {

        $query = "select id, user_id from make_reservations";
        $users = DB::select($query);

        foreach ($users as $currentUser){

            // increase consumed points + 1 ;
            // check if consumed points = user points
            // if they are equal cancel reservation  and update the state of reservation
            // canceled du to you don't have enough money

            // i should work her on created_at time

            $Curr_user = $user->find($currentUser->user_id);
            if($Curr_user->points == $Curr_user->consumed_points){
                // take his balance and cancel reservation
               app('App\Http\Controllers\UserController')
                   ->CancelReservation($currentUser->id,1,60);

            }else {
                $Curr_user->consumed_points +=1;
               // print('im in else ');
                $Curr_user->save();
            }
        }
        $this->info('Hour balance update has been done successfully');
    }
}
