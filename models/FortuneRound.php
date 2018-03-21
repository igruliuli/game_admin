<?php

namespace app\models;

class FortuneRound extends GameRound
{
    const SERVER_PORT = 0;

    protected function getCoefs($bet, $result)
    {
        // simple match
        if ($bet <= 36) {
            if ($bet == $result) {
                return 36;
            }
        }

        // row #1
        if ($bet == 37) {
            if (in_array($result, [1, 4, 7, 10, 13, 16, 19, 22, 25, 28, 31, 34])) {
                return 3;
            }
        }

        // row #2
        if ($bet == 38) {
            if (in_array($result, [2, 5, 8, 11, 14, 17, 20, 23, 26, 29, 32, 35])) {
                return 3;
            }
        }

        // row #3
        if ($bet == 39) {
            if (in_array($result, [3, 6, 9, 12, 15, 18, 21, 24, 27, 30, 33, 36])) {
                return 3;
            }
        }

        // part #1
        if ($bet == 40) {
            if (in_array($result, range(1, 12))) {
                return 3;
            }
        }

        // part #2
        if ($bet == 41) {
            if (in_array($result, range(13, 24))) {
                return 3;
            }
        }

        // part #3
        if ($bet == 42) {
            if (in_array($result, range(25, 36))) {
                return 3;
            }
        }

        // 1 - 18
        if ($bet == 43) {
            if (in_array($result, range(1, 18))) {
                return 2;
            }
        }

        // 19 - 36
        if ($bet == 44) {
            if (in_array($result, range(19, 36))) {
                return 2;
            }
        }

        // even number
        if ($bet == 45) {
            if ($result > 0 && ($result % 2 == 0)) {
                return 2;
            }
        }

        // odd number
        if ($bet == 46) {
            if ($result > 0 && ($result % 2 != 0)) {
                return 2;
            }
        }

        // red number
        if ($bet == 47) {
            if (in_array($result, [1, 3, 5, 7, 9, 12, 14, 16, 18, 19, 21, 23, 25, 27, 30, 32, 34, 36])) {
                return 2;
            }
        }

        // black
        if ($bet == 48) {
            if (in_array($result, [2, 4, 6, 8, 10, 11, 13, 15, 17, 20, 22, 24, 26, 28, 29, 31, 33, 35])) {
                return 2;
            }
        }

        // pair 0-3
        if ($bet == 100) {
            if (in_array($result, [0, 3])) {
                return 18;
            }
        }

        // pair 6-9
        if ($bet == 102) {
            if (in_array($result, [6, 9])) {
                return 18;
            }
        }

        // pair 2-5
        if ($bet == 104) {
            if (in_array($result, [12, 15])) {
                return 18;
            }
        }

        // pair 26-29
        if ($bet == 106) {
            if (in_array($result, [26, 29])) {
                return 18;
            }
        }

        // pair 5-8
        if ($bet == 109) {
            if (in_array($result, [5, 8])) {
                return 18;
            }
        }

        // pair 10-11
        if ($bet == 111) {
            if (in_array($result, [11, 10])) {
                return 18;
            }
        }

        // pair 13-16
        if ($bet == 114) {
            if (in_array($result, [13, 16])) {
                return 18;
            }
        }

        // pair 14-17
        if ($bet == 117) {
            if (in_array($result, [14, 17])) {
                return 18;
            }
        }

        // pair 17-20
        if ($bet == 118) {
            if (in_array($result, [17, 20])) {
                return 18;
            }
        }

        // pair 18-21
        if ($bet == 121) {
            if (in_array($result, [18, 21])) {
                return 18;
            }
        }

        // pair 32-35
        if ($bet == 123) {
            if (in_array($result, [32, 35])) {
                return 18;
            }
        }

        // pair 4-7
        if ($bet == 126) {
            if (in_array($result, [4, 7])) {
                return 18;
            }
        }

        // pair 23-24
        if ($bet == 129) {
            if (in_array($result, [23, 24])) {
                return 18;
            }
        }

        // pair 25-28
        if ($bet == 131) {
            if (in_array($result, [25, 28])) {
                return 18;
            }
        }

        // pair 19-22
        if ($bet == 133) {
            if (in_array($result, [19, 22])) {
                return 18;
            }
        }

        // pair 31-34
        if ($bet == 135) {
            if (in_array($result, [31, 34])) {
                return 18;
            }
        }

        // triplet 0-2-3
        if ($bet == 136) {
            if (in_array($result, [0, 2, 3])) {
                return 12;
            }
        }

        // pair 27-30
        if ($bet == 179) {
            if (in_array($result, [27, 30])) {
                return 18;
            }
        }

        // pair 33-36
        if ($bet == 187) {
            if (in_array($result, [33, 36])) {
                return 18;
            }
        }

        return 0;
    }

    public static function getWinBets($data = []){
        $bet = Bet::find()->where(['round_id' =>  $data['tir']])->one();
        if (isset($bet)){
            $betOperations = BetOperation::find()->where(['bet_id' => $bet->id])->one();

            $userBet = json_decode($betOperations->user_bet, 1);

            $coef = self::getCoefs($userBet[0], $data['ball']);


            \Yii::info($userBet[0], 'debug');


            $winAmount = $betOperations->amount * $coef;

            $betOperations->win_amount = $winAmount;
            $betOperations->result = ($winAmount > 0) ? 1 : 2;
            $betOperations->save();
            $bet->win_amount = $winAmount;
            $bet->result = ($winAmount > 0) ? 1 : 2;
            $bet->save();
        }


    }

    /**
     * @param \stdClass $history
     */
    public static function saveHistory($history)
    {
        $result = $history->fb;
        $id = $history->tir;
        $timeToFinish = $history->t2;

        if (is_null(static::findOne(['id' => $id, 'server_number' => static::SERVER_PORT]))) {
            static::createNew($id, [$result], $timeToFinish);
        }
    }

    public function createNew($id, $data, $timeToFinish, $g_name)
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
        $endTime->add(new \DateInterval('PT' . static::GAME_PERIOD . 'S'));
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