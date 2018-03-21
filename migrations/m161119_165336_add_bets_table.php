<?php

use yii\db\Migration;

class m161119_165336_add_bets_table extends Migration
{
    public function up()
    {
        $this->createTable(\app\models\Bet::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer(11)->unsigned()->notNull(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'amount' => $this->decimal(10, 2)->notNull()->defaultValue(0),
            'result' => $this->integer()->notNull()->defaultValue(\app\models\Bet::RESULT_NOT_READY)
        ]);

        $this->addForeignKey(
            'fk_bet_user_id',
            \app\models\Bet::tableName(),
            'user_id',
            \app\modules\user\models\User::tableName(),
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable(\app\models\Bet::tableName());
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
