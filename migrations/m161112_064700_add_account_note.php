<?php

use yii\db\Migration;

class m161112_064700_add_account_note extends Migration
{
    public function up()
    {
        $this->addColumn(\app\modules\user\models\Account::tableName(), 'note', $this->text());
    }

    public function down()
    {
        $this->dropColumn(\app\modules\user\models\Account::tableName(), 'note');
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
