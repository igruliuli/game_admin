<?php

namespace app\models;

class FortuneLiveRound extends GameRound
{
    const SERVER_PORT = 3303;

    /**
     * Fortune Live 3 min
     */
    const GAME_PERIOD = 168;
    const ROUND_DURATION = 180;


    /**
     * @param \stdClass $history
     */
    public static function saveHistory($history)
    {
        $result = $history->fb;
        $id = $history->tir;
        $timeToFinish = $history->t2;

        if (is_null(self::findOne(['id' => $id, 'server_number' => self::SERVER_PORT]))) {
            self::createNew($id, [$result], $timeToFinish);
        }
    }

    /**
     * @return \DateTime
     */
    public function nextRoundEnds()
    {
        $endTime = new \DateTime($this->end_time);
        $endTime->add(new \DateInterval('PT' . self::GAME_PERIOD . 'S'));
        return $endTime;
    }

    public function getData()
    {
        $results = new \stdClass();
        $secondsLeft = $this->nextRoundEnds()->getTimestamp() - (new \DateTime())->getTimestamp();

        if ($secondsLeft > 148) {
            $secondsLeft = 0 - (168 - $secondsLeft);
        }

        $results->t2 = $secondsLeft;
        $results->tir = $this->id;
        $results->fb = trim($this->results, '][');
        $results->ball = trim($this->results, '][');

        return $results;
    }
}