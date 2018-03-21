<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy
 * Date: 29.11.2017
 * Time: 11:22
 */

namespace app\modules\api\controllers;

use app\models\BillHistory;
use app\models\Cashdesk;
use app\modules\user\models\Account;
use app\modules\user\models\User;

class CashdeskController extends ApiController
{

    public function actionIndex($acc_id){
        return [['cd' => 0, 'balance' => Cashdesk::getBalance($acc_id)]];
    }

    public function actionTransfer($acc_id){
        $request = json_decode(\Yii::$app->request->getRawBody(),1);
        $cashdesk = Cashdesk::findOne(['account_id' => $acc_id]);
        $account = Account::findOne($acc_id);

        switch ($request['action']){
            case 'add':
                $cashdesk->addBalance($request['sum']);
                $account->decreaseBalance($request['sum']);
                $data = [
                    'amount' => $request['sum'],
                    'account_id' => $acc_id,
                    'op_type' => BillHistory::BALANS_PLUS,
                    'who_add' => 1001,
                ];
                $billHistory = new BillHistory();
                $billHistory->saveHistory($data);
                return 'success';
                break;

            case 'sub':
                $cashdesk->decreaseBalance($request['sum']);
                $account->addBalance($request['sum']);
                $data = [
                    'amount' => $request['sum'],
                    'account_id' => $acc_id,
                    'op_type' => BillHistory::BALANS_MINUS,
                    'who_add' => 1001,
                ];
                $billHistory = new BillHistory();
                $billHistory->saveHistory($data);
                return 'success';
                break;

        }
        print_r($request);
        return [];
    }
}