<?php

use yii\db\Migration;

class m161110_070008_add_accounts_table extends Migration
{
    public function up()
    {
        $this->createTable(
            \app\modules\user\models\Account::tableName(),
            [
                'id' => $this->primaryKey(11)->unsigned(),
                'parent_id' => $this->integer(11)->unsigned(),
                'name' => $this->string(128)->notNull(),
                'status' => $this->integer()->notNull()->defaultValue(1),
                'balance' => $this->decimal(12, 2)->notNull()->defaultValue(0),
                'created_at' => $this->dateTime()->defaultValue(new \yii\db\Expression('NOW()'))
            ]
        );

        $this->addForeignKey(
            'fk_account_parent_id',
            \app\modules\user\models\Account::tableName(),
            'parent_id',
            \app\modules\user\models\Account::tableName(),
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk_account_parent_id', \app\modules\user\models\Account::tableName());
        $this->dropTable(\app\modules\user\models\Account::tableName());
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
