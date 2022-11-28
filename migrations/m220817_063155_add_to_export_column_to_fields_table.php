<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%fields}}`.
 */
class m220817_063155_add_to_export_column_to_fields_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%fields}}', 'to_export', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%fields}}', 'to_export');
    }
}
