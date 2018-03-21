<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cashdesk".
 *
 * @property integer $id
 * @property integer $account_id
 * @property integer $balance
 */
class Cashdesk extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cashdesk';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id', 'balance'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account_id' => 'Account ID',
            'balance' => 'Balance',
        ];
    }

    public static function getBalance($acc_id)
    {
        return self::findOne(['account_id' => $acc_id])->balance;
    }

    public function addBalance($amount)
    {
        $this->balance +=  $amount;
        $this->save();
    }

    public function decreaseBalance($amount)
    {
        if ($amount > $this->balance) {
            throw new NotEnoughMoney();
        }

        $this->balance -= $amount;
        $this->save();
    }
}
