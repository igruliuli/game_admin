<?php

namespace app\modules\api\controllers;

use app\libraries\behaviors\JsonResponseBehavior;
use app\libraries\games\Fortune;
use app\models\FortuneRound;
use app\models\GameRound;
use yii\db\Exception;
use yii\web\Controller;

/**
 * @method  createResponse(array $data = [])
 */
class RoundController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'jsonResponse' => [
                'class' => JsonResponseBehavior::class,
            ],
        ];
    }

    public function actionResults($game_id = null)
    {
        $request = \Yii::$app->request;
        if ($request->isPost) {
            $date = new \DateTime();
            $request->getRawBody();
            $request->getUrl();

            return $request->getRawBody();
        }

        $server = $request->get('server');

        /** @var GameRound $result */
        $result = GameRound::getActiveResult($server);

        return $this->createResponse(is_null($result) ? [] : $result->getData());
    }

    public function actionSave($game_id = null)
    {
        $g_name = explode("/", \Yii::$app->request->get('game_id'))[0];
        $data = json_decode(\Yii::$app->request->getRawBody(), 1);

        $time = time()-3600;
        GameRound::deleteAll("end_time <" . $time);

        //Сейвим тиражи
            $g_round = new GameRound();
            $g_round->getGameIds($g_name);

            $id = GameRound::findOne(['id' => $data['tir']]);

            if (is_null($id))
                $g_round->createNew($data['tir'], $data, time(), $g_name);


        //Расчитываем ставку
        if (!in_array($g_name, ['fortuna15min', 'fortuna3min', 'FortuneBet'])){
            $class = GameRound::gameServers($g_name);
            $class::getWinBets($data);
        }else{
            //\Yii::info($g_name, 'debug');
            FortuneRound::getWinBets($data);
        }

        return '';
    }

    public function actionSaved($game_id = null)
    {
        $game_id = explode("/", \Yii::$app->request->get('game_id'))[0];
        $data = json_decode(\Yii::$app->request->getRawBody(), 1);

        return '';
    }
}