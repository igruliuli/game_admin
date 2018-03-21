<?php

namespace app\models;

class FortuneFastRound extends FortuneRound
{
    const SERVER_PORT = 3313;

    /**
     * Fortune Fast 1,5 min
     */
    const GAME_PERIOD = 78;
    const ROUND_DURATION = 90;

    public static function createNew($id, $data, $timeToFinish)
    {
        $record = new self();

        $endDate = new \DateTime();

        // next round begins
        if ($timeToFinish <= 0) {
            $finishedSecondsAgo = abs($timeToFinish);
        } else {
            $finishedSecondsAgo = $timeToFinish + 20;
        }

        $endDate->sub(new \DateInterval('PT' . $finishedSecondsAgo . 'S'));

        $record->id = $id;
        $record->server_number = self::SERVER_PORT;
        $record->end_time = $endDate->format('Y-m-d H:i:s');
        $record->results = json_encode($data);
        $record->save();

        return $record;
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

        if ($secondsLeft > 58) {
            $secondsLeft = 0 - (78 - $secondsLeft);
        }

        $results->t2 = $secondsLeft;
        $results->tir = $this->id;
        $results->fb = trim($this->results, '][');
        $results->ball = trim($this->results, '][');

        return $results;
    }
}