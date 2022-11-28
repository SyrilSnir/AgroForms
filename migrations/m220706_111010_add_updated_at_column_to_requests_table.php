<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%requests}}`.
 */
class m220706_111010_add_updated_at_column_to_requests_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%requests}}', 'updated_at', $this->integer()->unsigned());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%requests}}', 'updated_at');
    }
}
