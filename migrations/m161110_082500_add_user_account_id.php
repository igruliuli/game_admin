<?php

use yii\db\Migration;

class m161110_082500_add_user_account_id extends Migration
{
    public function up()
    {
        $this->addColumn(
            \app\modules\user\models\User::tableName(),
            'account_id',
            $this->integer(11)->unsigned()
        );

        $this->insert(
            \app\modules\user\models\Account::tableName(),
            ['name' => 'Test account']
        );

        $accountId = (new \yii\db\Query())->select('id')
            ->from(\app\modules\user\models\Account::tableName())
            ->scalar();

        $this->update(
            \app\modules\user\models\User::tableName(),
            ['account_id' => $accountId]
        );

        $this->execute("ALTER TABLE users ALTER COLUMN account_id SET NOT NULL");

        $this->addForeignKey(
            'fk_user_account_id',
            \app\modules\user\models\User::tableName(),
            'account_id',
            \app\modules\user\models\Account::tableName(),
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropColumn(\app\modules\user\models\User::tableName(), 'account_id');
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
