<?php

use yii\db\Migration;

class m161112_064025_change_account_relations extends Migration
{
    public function up()
    {
        $transaction = \Yii::$app->db->beginTransaction();

        try {
            $this->dropForeignKey('fk_account_parent_id', \app\modules\user\models\Account::tableName());
            $this->addForeignKey(
                'fk_account_parent_id',
                \app\modules\user\models\Account::tableName(),
                'parent_id',
                \app\modules\user\models\Account::tableName(),
                'id',
                'CASCADE',
                'CASCADE'
            );

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
        }
    }

    public function down()
    {
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
