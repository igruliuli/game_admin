<?php

namespace app\modules\api\controllers;

use app\libraries\games\Game;
use app\models\Bet;
use app\models\GameRound;
use app\modules\user\models\User;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\libraries\behaviors\JsonResponseBehavior;
use yii\web\ForbiddenHttpException;

/**
 * @method  createResponse(array $data = [])
 */
class InfoController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'jsonResponse' => [
                'class' => JsonResponseBehavior::className(),
            ],
/*            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function($rule, $action) {
                    throw new ForbiddenHttpException('Требуется авторизация', 403);
                },
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    ['allow' => false]
                ]
            ],*/
        ];
    }

    public function actionInfo()
    {
        $request = \Yii::$app->request;
        /** @var User $user */
        $user = User::find()->where(['token' => $_COOKIE['token']])->one();

        $dateStartStr = $request->get('dt1');
        $dateEndStr = $request->get('dt2');
        $code = $request->get('code');

        $query = Bet::find()
            ->where(['user_id' => $user->id]);

        if ($code) {
            $query->andWhere(['id' => $code]);
        } else {
            $query->andWhere(['between', 'created_at', $dateStartStr, $dateEndStr]);
        }

        /** @var Bet[] $bets */
        $bets = $query->all();
        $gamesBets = [];
        $resultsStr = '';

        foreach (Game::getGamesAbbrs() as $abbr) {
            $gamesBets[$abbr] = [
                'bet' => [],
                'max' => 0
            ];
        }

        foreach ($bets as $i => $bet) {
            $game = Game::getGameById($bet->game_id);

            $gamesBets[$game->getAbbr()]['bet'] = array_merge($bet->getOperationsInfo(), $gamesBets[$game->getAbbr()]['bet']);
            $gamesBets[$game->getAbbr()]['max'] = count($bet->operations) + $gamesBets[$game->getAbbr()]['max'];
        }

            if (count($bets) <= 1 && $bets[0]->result == 1) {
                $results = GameRound::getResults($game::NAME, $bets[0]->round_id);
                $resultsStr = implode(';', $results);
            }


        $code = (isset($code)) ? $code : 0;
        return $this->createResponse(array_merge([
            'status' => 'success',
            'key' => 0,
            "code" => $code,
            'bt' => "1",
            // TODO: wtf?
            'da' => $bets[0]->created_at,
            "st" => 'Info',
            "fiscaltyp" => 0,
            "fiscalsum" => 0,
            "cltbal" => 1,
            "limit" => $user->account->balance * 100,
            "cassir" => $user->id,
            "user" => '-',
            "faststate" => 1,
            "bw" => "0",
            "as" => "1000",
            "np" => '0',
            "aw" => '0',
            "trslt" => $resultsStr,
            "inf" => "",
            "tb" => count($bets),
            "mb" => count($bets)
        ], $gamesBets));
    }

    public function actionKassirreport (){
        $user = User::findIdentityByAccessToken($_COOKIE['token']);
        $request = \Yii::$app->request->get();
        $report = Bet::getKassirReport($user->id, $request['dt1'],$request['dt2']);
        $total_in = 0;


        $data = array (
            'status' => 'success',
            'key' => 964983141,
            'code' => '',
            'bt' => '1',
            'da' => '01.01.-10  00:00:00',
            'fiscaltyp' => 0,
            'fiscalsum' => 0,
            'cltbal' => 0,
            'limit' => '980000',
            'cassir' => '6060',
            'user' => '-',
            'faststate' => 4,
            'bw' => '1',
            'as' => $report[0]['total_in'],//оборот касира
            'np' => $report[0]['total_out'],//выпл кассира
            'tin' => $report[0]['total_in'],//общие прибыль исправить
            'tout' => $report[0]['total_out'],//общие выплаты исправить
            'cassirProfit' => $report[0]['delta'],
            'allProfit' => $report[0]['delta'],
            'aw' => '0',
            'trslt' => '6 Черное',
            'inf' => '',
            'st' => 'Info',
            'tb' => '2',
            'mb' => '2',
        );
        \Yii::info($report, 'debug');
        return $data;
    }
}