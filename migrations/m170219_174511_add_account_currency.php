<?php

use yii\db\Migration;

class m170219_174511_add_account_currency extends Migration
{
    public function up()
    {
        $this->addColumn(
            \app\modules\user\models\Account::tableName(),
            'currency',
            $this->string(3)->notNull()->defaultValue(\app\modules\user\models\Account::CURRENCY_KZT)
        );
    }

    public function down()
    {
        $this->dropColumn(\app\modules\user\models\Account::tableName(), 'currency');
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
