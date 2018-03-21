<?php

use yii\db\Migration;

class m161113_060330_change_account_id_seq extends Migration
{
    public function up()
    {
        $this->execute('UPDATE accounts SET id = id + 1000');
        $maxId = (new \yii\db\Query())
            ->select(new \yii\db\Expression('MAX(id)'))
            ->from('accounts')
            ->scalar();

        $this->execute('ALTER SEQUENCE accounts_id_seq RESTART WITH ' . ($maxId + 1));

        $this->execute("SELECT calculate_hierarchy()");
    }

    public function down()
    {
        $this->execute('UPDATE accounts SET id = id - 1000');
        $maxId = (new \yii\db\Query())
            ->select(new \yii\db\Expression('MAX(id)'))
            ->from('accounts')
            ->scalar();

        $this->execute('ALTER SEQUENCE accounts_id_seq RESTART WITH ' . ($maxId + 1));

        $this->execute("SELECT calculate_hierarchy()");
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
