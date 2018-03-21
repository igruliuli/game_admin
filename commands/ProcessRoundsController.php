<?php

namespace app\commands;

use app\libraries\kassa\KassaAgentService;
use app\models\Bet;
use yii\base\Exception;
use yii\console\Controller;

class ProcessRoundsController extends Controller
{
    public function actionIndex()
    {
        $i = 0;

        // time to live for this script (in sec)
        $ttl = 100;

        $timeStarted = (new \DateTime())->format('H:i:s');

        while ($i < $ttl) {

            //echo $timeStarted . " Iteration #" . $i . PHP_EOL;

            $now = (new \DateTime())->format('H:i:s');

            try {
                /** @var Bet[] $bets */
                $bets = Bet::findAll([
                    'result' => Bet::RESULT_NOT_READY
                ]);

                foreach ($bets as $bet) {
                    $round = $bet->getRound();

                    if ($round) {
                        $bet->processResults();
                    } else {
                        echo $now . ' Missing round. Bet #' . $bet->id . PHP_EOL;
                    }
                }

            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
            $i++;
            sleep(1);
        }
    }
}