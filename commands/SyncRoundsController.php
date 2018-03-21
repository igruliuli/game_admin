<?php

namespace app\commands;

use app\libraries\games\KenoLive;
use app\libraries\kassa\KassaAgentService;
use app\models\FortuneBetRound;
use app\models\FortuneFastRound;
use app\models\FortuneLiveRound;
use app\models\KenoBetRound;
use app\models\KenoGoldRound;
use app\models\KenoLiveRound;
use yii\base\Exception;
use yii\console\Controller;
use yii\helpers\Console;

class SyncRoundsController extends Controller
{
    public function actionIndex()
    {
        $service = new KassaAgentService();

        $i = 0;
        // time to live for this script (in sec)
        $ttl = 100;

        $timeStarted = (new \DateTime())->format('H:i:s');

        while ($i < $ttl) {

            echo $timeStarted . " Iteration #" . $i . PHP_EOL;

            $now = new \DateTime();
            $startTime = $now->add(new \DateInterval('PT45M'))->format('Y-m-d H:i:s');
            $endTime = $now->add(new \DateInterval('PT10H'))->format('Y-m-d H:i');

            try {

                // Keno Bet
                $kenoBetHistory = $service->getKenoBetHistory();
                if (is_object($kenoBetHistory) && property_exists($kenoBetHistory, 'tir')) {
                    KenoBetRound::saveHistory($kenoBetHistory);
                }

                // Keno Gold
                $history = $service->getKenoGoldHistory($startTime, $endTime);

                if (is_object($history) && property_exists($history, 'tir')) {
                    KenoGoldRound::saveHistory((array)$history->tir);
                }

                // Keno Live
                $history = $service->getKenoLiveHistory($startTime, $endTime);

                if (is_object($history) && property_exists($history, 'tir')) {
                    KenoLiveRound::saveHistory((array)$history->tir);
                }

                // Fortune Live
                $fortuneLiveHistory = $service->getFortuneLiveHistory();

                if (is_object($fortuneLiveHistory) && property_exists($fortuneLiveHistory, 'tir')) {
                    FortuneLiveRound::saveHistory($fortuneLiveHistory);
                }

                // Fortune Fast
                $fortuneFastHistory = $service->getFortuneFastHistory();

                if (is_object($fortuneFastHistory) && property_exists($fortuneFastHistory, 'tir')) {
                    FortuneFastRound::saveHistory($fortuneFastHistory);
                }

                // Fortune Bet
                $fortuneBetHistory = $service->getFortuneBetHistory();

                //Console::output($fortuneBetHistory->tir . ' time: ' . $fortuneBetHistory->t2);

                if (is_object($fortuneBetHistory) && property_exists($fortuneBetHistory, 'tir')) {
                    FortuneBetRound::saveHistory($fortuneBetHistory);
                }

            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
            $i++;
            sleep(1);
        }
    }
}