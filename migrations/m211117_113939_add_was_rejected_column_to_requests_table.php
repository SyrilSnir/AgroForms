<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%requests}}`.
 */
class m211117_113939_add_was_rejected_column_to_requests_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%requests}}', 'was_rejected', $this->boolean()->notNull()->defaultValue(false)->comment('Заявка ранее была отклонена'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%requests}}', 'was_rejected');
    }
}
