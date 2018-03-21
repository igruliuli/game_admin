<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy
 * Date: 23.11.2017
 * Time: 0:27
 */

namespace app\modules\api\controllers;

use app\libraries\behaviors\JsonResponseBehavior;
use app\models\Games;
use yii\helpers\ArrayHelper;


class SettingsController extends ApiController
{
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

    public function actionIndex(){
        $games = Games::find()->asArray()->all();
        $data = ['force' => 1, 'sources' => $games
        ];
        return $data;
    }

    public function actionBetAmount(){
        $request = json_decode(\Yii::$app->request->getRawBody());

        if ($request->all == true){
            Games::updateAll([
                'min_bet' => $request->min,
                'max_bet' => $request->max,
            ], [
                'enabled' => 1
            ]);
        }else{
            $game = Games::findOne($request->source);
            $game->min_bet = $request->min;
            $game->max_bet = $request->max;
            $game->save();
        }

        return ["result" => "success"];
    }

}