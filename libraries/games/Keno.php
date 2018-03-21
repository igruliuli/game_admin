<?php

namespace app\libraries\games;

use app\models\BetOperation;

abstract class Keno extends Game
{
    private $payTable = [
        1 => [
            1 => 3.5
        ],
        2 => [
            1 => 1,
            2 => 10
        ],
        3 => [
            2 => 2,
            3 => 50
        ],
        4 => [
            2 => 1,
            3 => 10,
            4 => 100,
        ],
        5 => [
            2 => 1,
            3 => 3,
            4 => 20,
            5 => 150,
        ],
        6 => [
            3 => 2,
            4 => 15,
            5 => 60,
            6 => 500,
        ],
        7 => [
            0 => 1,
            3 => 2,
            4 => 4,
            5 => 20,
            6 => 80,
            7 => 1000,
        ],
        8 => [
            0 => 1,
            4 => 5,
            5 => 15,
            6 => 50,
            7 => 200,
            8 => 2000
        ],
        9 => [
            0 => 2,
            4 => 1,
            5 => 10,
            6 => 25,
            7 => 125,
            8 => 1000,
            9 => 5000
        ],
        10 => [
            0 => 2,
            5 => 5,
            6 => 30,
            7 => 100,
            8 => 300,
            9 => 2000,
            10 => 10000
        ]
    ];

    public function getResult($bet, $results)
    {
        $bets = $bet->getBets();

        $match = array_intersect($results, $bets);

        $matchSize = count($match);
        $betSize = count($bets);

        if (!array_key_exists($betSize, $this->payTable)) {
            return 0;
        }

        if (!array_key_exists($matchSize, $this->payTable[$betSize])) {
            return 0;
        }

        return $bet->amount * $this->payTable[$betSize][$matchSize];
    }

    /** @return array */
    public function prepareBet($rawData)
    {
        return explode(';', $rawData);
    }

    public function createBetOperations($rawData)
    {
        $operation = new BetOperation();
        $operation->user_bet = json_encode($this->prepareBet($rawData['bet']));
        $operation->amount = $rawData['sum'] / 100;

        return [$operation];
    }

    public function getFactor($bet, $round_id)
    {
        $betSize = count($bet);
        if (isset($this->payTable[$betSize][$betSize]))
            return $this->payTable[$betSize][$betSize];
        return 0;
    }
}