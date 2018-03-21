<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "games".
 *
 * @property integer $id
 * @property string $name
 * @property integer $status
 * @property integer $enabled
 * @property integer $min_bet
 * @property integer $max_bet
 */
class Games extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'games';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'min_bet', 'max_bet', 'enabled'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'status' => 'Status',
            'enable' => 'Enable',
            'min_bet' => 'Min Bet',
            'max_bet' => 'Max Bet',
        ];
    }
}
