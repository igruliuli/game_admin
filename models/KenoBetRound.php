<?php

namespace app\models;

class KenoBetRound extends GameRound
{
    const G_NAME = 'KenoBet';

    public static function getWinBets($data = []){
        $bet = Bet::find()->where(['round_id' =>  $data['tir']])->one();
        if (isset($bet)){
            $betOperations = BetOperation::find()->where(['bet_id' => $bet->id])->one();
            $countWinBols = 0;

            $userBet = json_decode($betOperations->user_bet, 1);
            $countSetBols = count($userBet);

            for ($i = 1; $i <= 20; $i++){
                //Ищем число совпадений
                if (array_search($data['b'.$i], $userBet)){
                    $countWinBols += 1;
                }
            }

            $coef = self::getCoefs($countSetBols, $countWinBols);
            $winAmount = $betOperations->amount * $coef;

            $betOperations->win_amount = $winAmount;
            $betOperations->result = ($winAmount > 0) ? 1 : 2;
            $betOperations->save();
            $bet->win_amount = $winAmount;
            $bet->result = ($winAmount > 0) ? 1 : 2;
            $bet->save();
        }


    }
    public static function getCoefs($countSetBols, $countWinBols)
    {
        $winCoef = [
            1 => [
                1 => 3
            ],
            2 => [
                1 => 1,
                2 => 10
            ],
            3 => [
                1 => 0,
                2 => 2,
                3 => 45
            ],
            4 => [
                1 => 0,
                2 => 1,
                3 => 10,
                4 => 80
            ],
            5 => [
                1 => 0,
                2 => 1,
                3 => 3,
                4 => 20,
                5 => 150
            ],
            6 => [
                1 => 0,
                2 => 0,
                3 => 2,
                4 => 15,
                5 => 60,
                6 => 500
            ],
            7 => [
                0 => 1,
                1 => 0,
                2 => 0,
                3 => 2,
                4 => 4,
                5 => 20,
                6 => 80,
                7 => 1000
            ],
            8 => [
                0 => 1,
                1 => 0,
                2 => 0,
                3 => 0,
                4 => 5,
                5 => 15,
                6 => 50,
                7 => 200,
                8 => 2000
            ],
            9 => [
                0 => 2,
                1 => 0,
                2 => 0,
                3 => 0,
                4 => 2,
                5 => 10,
                6 => 25,
                7 => 125,
                8 => 1000,
                9 => 5000
            ],
            10 => [
                0 => 2,
                1 => 0,
                2 => 0,
                3 => 0,
                4 => 0,
                5 => 5,
                6 => 30,
                7 => 100,
                8 => 300,
                9 => 2000,
                10 => 10000
            ]
        ];
        if (isset($winCoef[$countSetBols][$countWinBols]))
            return $winCoef[$countSetBols][$countWinBols];
        return 0;
    }
}