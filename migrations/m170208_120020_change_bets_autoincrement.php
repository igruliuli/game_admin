<?php

use yii\db\Migration;

class m170208_120020_change_bets_autoincrement extends Migration
{
    public function up()
    {
        $this->execute('ALTER SEQUENCE bets_id_seq RESTART WITH 1000000000000');
    }

    public function down()
    {
        echo "m170208_120020_change_bets_autoincrement cannot be reverted.\n";

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
