<?php

use yii\db\Migration;

/**
 * Handles the creation for table `round_results`.
 */
class m161218_144528_create_round_results_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable(\app\models\GameRound::tableName(), [
            'id' => $this->integer()->unsigned()->notNull(),
            'server_number' => $this->integer()->unsigned()->notNull(),
            'results' => $this->text(),
            'end_time' => $this->dateTime()->notNull()
        ]);

        $this->createIndex('idx_unique_round_id', \app\models\GameRound::tableName(), ['id', 'server_number'], true);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable(\app\models\GameRound::tableName());
    }
}
