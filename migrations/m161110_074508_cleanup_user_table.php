<?php

use yii\db\Migration;

class m161110_074508_cleanup_user_table extends Migration
{
    public function up()
    {
        $this->dropColumn(\app\modules\user\models\User::tableName(), 'parent_id');
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
