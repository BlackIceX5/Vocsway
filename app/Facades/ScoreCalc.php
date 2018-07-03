<?php

namespace App\Facades;
use App\Score;
use App\Car;
class ScoreCalc
{

    public function exist($id)
    {
        $score = Score::where('car_id', $id)->first();
		if ( $score){
			if($score->points >= ($score->level * 2)){
				$score->score = $score->score + 10;
				$score->level = $score->level * 2;
				$score->save();
				$car = Car::where('id', $id)->first();
				$car->score = $score->score;
				$car->save();
			}
			
			return true;
		}
		else{
			$newScore = new Score;
			$newScore->car_id = $id;
			$newScore->points = 0;
			$newScore->score = 10;
			$newScore->level = 10;
			$newScore->save();
			return false;
		}
		
    }
	
	public function newPoints($id, $points)
    {
        $score = Score::where('car_id', $id)->first();
		$score->points = $score->points + $points;
		
		if($score->points >= ($score->level * 2)){
			do {
				$score->score = $score->score + 10;
				$score->level = $score->level * 2;
				$score->save();
				
			} while ($score->points >= ($score->level * 2));
			$car = Car::where('id', $id)->first();
			$car->score = $score->score;
			$car->save();
			return $score;
		}
		else{
			$score->save();
			return false;
		}
    }
	
	public function deletePoints($id, $points)
    {
        $score = Score::where('car_id', $id)->first();
		$score->points = $score->points - $points;
		$score->save();
		return true;
	}

}