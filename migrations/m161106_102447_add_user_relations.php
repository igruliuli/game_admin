<?php

use yii\db\Migration;

class m161106_102447_add_user_relations extends Migration
{
    public function up()
    {
        $this->addColumn(\app\modules\user\models\User::tableName(),
            'parent_id',
            $this->integer(11)->unsigned()
        );

        $this->addForeignKey(
            'fk_user_parent_id',
            \app\modules\user\models\User::tableName(),
            'parent_id',
            \app\modules\user\models\User::tableName(),
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk_user_parent_id', \app\modules\user\models\User::tableName());
        $this->dropColumn(\app\modules\user\models\User::tableName(), 'parent_id');
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
