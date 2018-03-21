<?php

use yii\db\Migration;

class m170208_123335_additional_bet_fields extends Migration
{
    public function up()
    {
        $this->addColumn(\app\models\Bet::tableName(), 'status', $this->integer()->notNull()->defaultValue(\app\models\Bet::STATUS_UNPAID));
        $this->addColumn(\app\models\Bet::tableName(), 'user_paid_id', $this->integer()->null()->defaultValue(null));
        $this->addForeignKey(
            'fk_bet_user_paid_id',
            \app\models\Bet::tableName(),
            'user_paid_id',
            \app\modules\user\models\User::tableName(),
            'id',
            'SET NULL',
            'CASCADE'
        );
        $this->addColumn(\app\models\Bet::tableName(), 'paid_date', $this->dateTime()->null()->defaultValue(null));
    }

    public function down()
    {
        $this->dropColumn(\app\models\Bet::tableName(), 'status');
        $this->dropColumn(\app\models\Bet::tableName(), 'user_paid_id');
        $this->dropColumn(\app\models\Bet::tableName(), 'paid_date');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
