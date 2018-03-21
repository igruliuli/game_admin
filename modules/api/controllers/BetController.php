<?php

namespace app\modules\api\controllers;

use app\libraries\behaviors\JsonResponseBehavior;
use app\libraries\games\Game;
use app\models\Bet;
use app\models\Cashdesk;
use app\modules\user\models\User;
use yii\web\Controller;

/**
 * @method  createResponse(array $data = [])
 */
class BetController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'jsonResponse' => [
                'class' => JsonResponseBehavior::class,
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

    public function actionSave()
    {
        $request = \Yii::$app->request;
        /** @var User $user */

        $user = User::find()->where(['token' => $_COOKIE['token']])->one();
        $post = $request->post();

        // how to accept game_id = 6_6_6_6
        // they are store fortune bets each separately? hm

        $gameId = $post['game_id'];

        if (strpos($gameId, '_')) {
            $gameId = substr($gameId, 0, strpos($gameId, '_'));
        }

        $game = Game::getGameById($gameId);
        $roundId = $post['round_id'];
        $userBet = $game->prepareBet($post['bet']);

        $operations = $game->createBetOperations($post);


        $bet = new Bet();
        $amount = $bet->getAmountFromOperations($operations);


        $bet->amount = $amount;
        $bet->user_id = $user->id;
        $bet->user_bet = json_encode($userBet);
        $bet->round_id = $roundId;
        $bet->game_id = $gameId;
        $bet->save();

        $cashdesk = Cashdesk::findOne(['account_id' => $user->account->id]);
        $cashdesk->addBalance($amount);

        $bet->saveOperations($operations);
        $user->account->decreaseBalance($amount);

        $gamesBets = [];

        /*        foreach (Game::getGamesAbbrs() as $abbr) {
                    if ($game->getAbbr() == $abbr) {
                            $gamesBets[$abbr] = [
                                "bet" => [$bet->getCheckData()],
                                "max" => 1
                            ];

                    } else {
                        $gamesBets[$abbr] = ['max' => 0];
                    }
                }*/

        foreach (Game::getGamesAbbrs() as $abbr) {
            if ($game->getAbbr() == $abbr) {
                $i = 0;

                foreach ($operations as $oper) {
                    \Yii::info(json_decode($oper->user_bet, 1), 'debug');
                    $user_bet = json_decode($oper->user_bet, 1);
                    $user_bet = (is_array($user_bet)) ? implode(",", $user_bet) : $user_bet[0];

                    $gamesBets[$abbr]['bet'][] = [
                        "tir" => $roundId,
                        "dact" => (new \DateTime($bet->created_at))->format('d.m.y  H:i:s'),
                        'nm' => $user_bet,
                        'cf' => ($game->getFactor((int)json_decode($oper->user_bet, 1)[0], $roundId) * 100),
                        'sm' => ($oper->amount * 100),
                    ];
                    $i++;
                }
                $gamesBets[$abbr]['max'] = $i;

            } else {
                $gamesBets[$abbr] = ['max' => 0];
            }
        }

        if (isset($gamesBets['rul']['bet']))
            $gamesBets['rul']['bet'][0]['tir'] = explode("_", $gamesBets['rul']['bet'][0]['tir'])[0];


        return $this->createResponse(array_merge($gamesBets, [
            'status' => 'success',
            'tb' => 1,
            'bt' => 0,
            'currency' => $user->account->currency,
            'fiscalsum' => 0,
            "st" => "Ставки приняты",
            "code" => (string)($bet->id),
            "da" => (new \DateTime($bet->created_at))->format('d.m.Y H:i:s'),
            "cltbal" => 0,
            "limit" => $user->account->balance * 100,
            "cashdesk" => Cashdesk::getBalance($user->account->id),
            "as" => $bet->amount * 100,
            // TODO:
            "aw" => 0, // общий выигрыш
            "cassir" => $user->login,
            // TODO:
            "trslt" => "Не окончен",
            "mb" => 1
        ]));
    }

    public function actionPay()
    {
        $request = \Yii::$app->request;
        $betId = (int)$request->post('bet_id');
        /** @var User $user */
        $user = User::find()->where(['token' => $_COOKIE['token']])->one();
        $account = $user->account;


        /** @var Bet $bet */
        $bet = Bet::findOne($betId);

        if (is_null($bet) || $bet->user->account_id != $user->account_id) {

            if (!is_null($bet) && $bet->user->account_id != $user->account_id) {
                $message = "Attempt to pay check {$betId} from wrong account {$user->account_id}";
            }
            return $this->createResponse(['st' => "Произошла ошибка, повторите действие"]);
        }

        $lastBet = Bet::find()->orderBy('id DESC')->one();
        if ($lastBet->id != $betId && $bet->result == 0)
            return $this->createResponse(['st' => "Отменить возможно только посленюю ставку."]);


        if ($bet->status == Bet::STATUS_PAID) {
            $message = "Не возможно вернуть ставку";
            return $this->createResponse(['st' => $message]);
        }

        $bet->pay($user);


        $game = Game::getGameById($bet->game_id);

        $gamesBets = [];
        foreach (Game::getGamesAbbrs() as $abbr) {
            if ($game->getAbbr() == $abbr) {
                $gamesBets[$abbr] = [
                    "bet" => [$bet->getCheckData()],
                    "max" => 1
                ];
            } else {
                $gamesBets[$abbr] = ['max' => 0];
            }
        }

        $cashdesk = Cashdesk::findOne(['account_id' => $user->account->id]);
        if ($bet->win_amount > 0) {
            $cashdesk->decreaseBalance($bet->win_amount);
        } else {
            $cashdesk->decreaseBalance($bet->amount);
        }


        return $this->createResponse(array_merge([
            'currency' => $account->currency,
            'status' => 'success',
            'code' => $bet->getFormattedCode(),
            'da' => (new \DateTime($bet->created_at))->format('d.m.y  H:i:s'),
            "st" => 'Info',
            "fiscaltyp" => 0,
            "fiscalsum" => 0,
            "cltbal" => 0,
            'limit' => $user->account->balance * 100,
            "cassir" => $user->id,
            "faststate" => 3,
            "bw" => 1,
            'as' => $bet->amount * 100,
            "np" => '0',
            "aw" => '0', // общий выигрыш
            "trslt" => "0",
            // TODO: result str
            "inf" => "",
            "tb" => 1,
            "mb" => 1
        ], $gamesBets));
    }

    public function actionCancel()
    {
        // TODO: implement cancel logic
    }
}