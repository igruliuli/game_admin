<?php

use yii\db\Migration;

class m170121_092759_add_bet_game_id extends Migration
{
    public function up()
    {
        $this->addColumn(
            \app\models\Bet::tableName(),
            'game_id',
            $this->integer(5)
        );

        $this->createIndex('idx_bet_game_id', \app\models\Bet::tableName(), 'game_id');
    }

    public function down()
    {
        $this->dropColumn(\app\models\Bet::tableName(), 'game_id');
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
