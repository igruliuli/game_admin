<?php

use yii\db\Migration;

class m170116_104903_add_updated_column_for_bet extends Migration
{
    public function up()
    {
        $this->addColumn(
            \app\models\Bet::tableName(),
            'updated_at',
            $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')
        );
    }

    public function down()
    {
        $this->dropColumn(\app\models\Bet::tableName(), 'updated_at');
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
