<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $end_time
 * @property array $results
 * @property integer $server_number
 * @property integer $g_name
 */
class GameRound extends ActiveRecord
{
    private $game_id;

    public static function tableName()
    {
        return '{{game_rounds}}';
    }

    public static function getActiveResult($serverNumber)
    {
        $class = self::gameServers($serverNumber);

        if ($class == null) {
            return null;
        }

        $existRecord = $class::find()
            ->where(['server_number' => $serverNumber])
            ->orderBy(['id' => SORT_DESC])
            ->one();

        return $existRecord;
    }

    public static function gameServers($g_name)
    {
        $servers = [
            KenoLiveRound::G_NAME => KenoLiveRound::class,
            KenoJXRound::G_NAME => KenoJXRound::class,
            KenoBetRound::G_NAME => KenoBetRound::class,
            KenoGoldRound::G_NAME => KenoGoldRound::class,
            KenoFastRound::G_NAME => KenoFastRound::class,
            /*            FortuneLiveRound::G_NAME => FortuneLiveRound::class,
                        FortuneFastRound::G_NAME => FortuneFastRound::class,
                        FortuneBetRound::G_NAME => FortuneBetRound::class*/
        ];

        if (!array_key_exists($g_name, $servers)) {
            return null;
        }

        return $servers[$g_name];
    }

    public static function getResults($gameName, $roundId)
    {
        $results = GameRound::find()->where(['g_name' => $gameName, 'id' => $roundId])->one();
        if (isset($results)){
            $results = json_decode($results->results, 1);
            $i = 1;
            if (isset($results['b1']))
                while (isset($results['b' . $i])) {
                    $results_[$i - 1] = $results['b' . $i];
                    $i++;
                }
            if (isset($results['ball']))
                $results_ = $results['ball'];
            return $results_;
        }
        return 0;
    }

    public function getGameIds($g_name)
    {
        $games = [
            'fortuna15min' => 3313,
            'fortuna3min' => 3303,
            'FortuneBet' => 3307,
            'keno4min' => 3302,
            'keno2min' => 3311,
            'kenoGold' => 3309,
            'JxKeno' => 3308,
            'KenoBet' => 3310,
        ];
        $this->game_id = $games[$g_name];
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
        $record->server_number = $this->game_id;
        $record->end_time = $timeToFinish;
        $record->results = json_encode($data);
        $record->g_name = $g_name;
        $record->save();

        return $record;
    }

    public function getData()
    {
        $results = new \stdClass();
        $secondsLeft = $this->nextRoundEnds()->getTimestamp() - (new \DateTime())->getTimestamp();

        if ($secondsLeft < 0) {
            $secondsLeft = 0;
        }

        $results->t2 = $secondsLeft;
        $results->tir = $this->id;

        return $results;
    }

    public function nextRoundEnds()
    {
        return new \DateTime();
    }
}