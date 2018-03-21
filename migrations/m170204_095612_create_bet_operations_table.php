<?php

use yii\db\Migration;

/**
 * Handles the creation for table `bet_operations`.
 */
class m170204_095612_create_bet_operations_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable(\app\models\BetOperation::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'bet_id' => $this->integer(11)->unsigned()->notNull(),
            'amount' => $this->decimal(10, 2)->notNull()->defaultValue(0),
            'win_amount' => $this->decimal(10, 2),
            'result' => $this->integer()->notNull()->defaultValue(\app\models\BetOperation::RESULT_NOT_READY),
            'user_bet' => $this->text()
        ]);

        $this->createIndex('idx_bet_operation_result', \app\models\BetOperation::tableName(), 'result');

        $this->addForeignKey(
            'fk_bet_bet_id',
            \app\models\BetOperation::tableName(),
            'bet_id',
            \app\models\Bet::tableName(),
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable(\app\models\BetOperation::tableName());
    }
}
