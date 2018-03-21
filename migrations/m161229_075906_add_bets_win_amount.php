<?php

use yii\db\Migration;

class m161229_075906_add_bets_win_amount extends Migration
{
    public function up()
    {
        $this->addColumn(
            \app\models\Bet::tableName(),
            'win_amount',
            $this->decimal(10, 2)
        );
    }

    public function down()
    {
        $this->dropColumn(\app\models\Bet::tableName(), 'win_amount');
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
