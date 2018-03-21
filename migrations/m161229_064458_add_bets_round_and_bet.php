<?php

use yii\db\Migration;

class m161229_064458_add_bets_round_and_bet extends Migration
{
    public function up()
    {
        $this->addColumn(
            \app\models\Bet::tableName(),
            'round_id',
            $this->integer()->notNull()->defaultValue(0)
        );

        $this->createIndex('idx_bet_round_id', \app\models\Bet::tableName(), 'round_id');

        $this->addColumn(
            \app\models\Bet::tableName(),
            'user_bet',
            $this->text()
        );
    }

    public function down()
    {
        $this->dropColumn(\app\models\Bet::tableName(), 'round_id');
        $this->dropColumn(\app\models\Bet::tableName(), 'user_bet');
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
