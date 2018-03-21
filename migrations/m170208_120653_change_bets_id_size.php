<?php

use yii\db\Migration;

class m170208_120653_change_bets_id_size extends Migration
{
    public function up()
    {
        $this->alterColumn(\app\models\Bet::tableName(), 'id', $this->bigInteger());
        $this->alterColumn(\app\models\BetOperation::tableName(), 'bet_id', $this->bigInteger());
    }

    public function down()
    {
        echo "m170208_120653_change_bets_id_size cannot be reverted.\n";

        return false;
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
