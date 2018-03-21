<?php

use yii\db\Migration;

class m161114_045531_add_bet_settings_field extends Migration
{
    public function up()
    {
        $this->addColumn(
            \app\modules\user\models\Account::tableName(),
            'bet_settings',
            $this->text()->defaultValue(json_encode(\app\modules\user\models\Account::betSettingsDefault()))
        );
    }

    public function down()
    {
        $this->dropColumn(
            \app\modules\user\models\Account::tableName(),
            'bet_settings'
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
