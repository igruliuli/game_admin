<?php

use yii\db\Migration;

class m161113_081705_add_account_permission_fields extends Migration
{
    public function up()
    {
        $this->addColumn(
            \app\modules\user\models\Account::tableName(),
            'can_change_minmax',
            $this->boolean()->defaultValue(false)
        );

        $this->addColumn(
            \app\modules\user\models\Account::tableName(),
            'can_change_accounts',
            $this->boolean()->defaultValue(false)
        );
    }

    public function down()
    {
        $this->dropColumn(
            \app\modules\user\models\Account::tableName(),
            'can_change_minmax'
        );

        $this->dropColumn(
            \app\modules\user\models\Account::tableName(),
            'can_change_accounts'
        );
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
