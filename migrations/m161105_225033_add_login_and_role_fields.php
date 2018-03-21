<?php

use yii\db\Migration;

class m161105_225033_add_login_and_role_fields extends Migration
{
    public function up()
    {
        $this->addColumn(\app\modules\user\models\User::tableName(), 'login', $this->string(255)->notNull()->unique()->defaultValue(''));
        $this->addColumn(\app\modules\user\models\User::tableName(), 'realm', $this->string(128)->notNull()->defaultValue(''));

        $this->renameColumn(\app\modules\user\models\User::tableName(), 'first_name', 'name');

        // create first admin
        \app\modules\user\models\User::createFirstAdmin();
    }

    public function down()
    {
        $this->dropColumn(\app\modules\user\models\User::tableName(), 'login');
        $this->dropColumn(\app\modules\user\models\User::tableName(), 'realm');
        $this->renameColumn(\app\modules\user\models\User::tableName(), 'name', 'first_name');
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
