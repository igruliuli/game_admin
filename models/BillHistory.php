<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bill_history".
 *
 * @property integer $id
 * @property string $amount
 * @property integer $account_id
 * @property integer $op_type
 * @property string $date
 * @property integer $who_add
 */
class BillHistory extends \yii\db\ActiveRecord
{
    const BALANS_PLUS = 1;
    const BALANS_MINUS = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bill_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amount', 'account_id', 'who_add'], 'required'],
            [['amount'], 'number'],
            [['account_id', 'op_type', 'who_add'], 'integer'],
            [['date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'amount' => 'Amount',
            'account_id' => 'Account ID',
            'op_type' => 'Op Type',
            'date' => 'Date',
            'who_add' => 'Who Add',
        ];
    }

    public function saveHistory($data){
        $this->attributes = $data;
        $this->save();
        return true;
    }
}
