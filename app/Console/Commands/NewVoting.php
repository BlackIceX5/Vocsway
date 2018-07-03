<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Car;
use App\VotingProces;
use App\VotingResult;
use Carbon\Carbon;

class NewVoting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'new:voting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create New voting day';

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
    public function handle()
    {
        // NEW VOTING DAY RECORD IN DB WITH RANDOM CARS
        $cars = Car::select(['id'])->inRandomOrder()->get(3);
        $newVote = new VotingProces;
        $i = 1;
        foreach( $cars as  $car ) {
            if($i == 1){
                $newVote->car1 =  $car->id;
                $i++;
            }
            elseIf($i == 2){
                $newVote->car2 =  $car->id;
                $i++;
            }else{
                $newVote->car3 =  $car->id;
                $i++;
            }
        }
        $newVote->date =  Carbon::today()->format('Y-m-d');
        $newVote->resCar1 = 0;
        $newVote->resCar2 = 0;
        $newVote->resCar3 = 0;
        $newVote->save();

        //OLD VOTING CALC
        $oldVote = VotingProces::where('date', Carbon::yesterday()->format('Y-m-d'))->first();
        if( $oldVote->resCar1 >= $oldVote->resCar2 ){
            if( $oldVote->resCar1 >= $oldVote->resCar3){
                $Viner = $oldVote->car1;
                $Vote = $oldVote->resCar1;
            }
            else{
                $Viner = $oldVote->car3;
                $Vote = $oldVote->resCar3;
            }
        }else{
            if( $oldVote->resCar2 >= $oldVote->resCar3){
                $Viner = $oldVote->car2;
                $Vote = $oldVote->resCar2;
            }
            else{
                $Viner = $oldVote->car3;
                $Vote = $oldVote->resCar3;
            }
        }
        $result = new VotingResult;
        $carViner = Car::find($Viner);
        $result->carId = $carViner->id;
        $result->make = $carViner->make;
        $result->model = $carViner->model;
        $result->nickAuto = $carViner->nickauto;
        $result->votes = ( $oldVote->resCar1+$oldVote->resCar2+$oldVote->resCar3 ).'/'.$Vote;
        $result->date = Carbon::today()->format('Y-m-d');
        $result->save();

        $this->info('The Voting Day is Created!'.date("h:i:sa"));
    }


}
