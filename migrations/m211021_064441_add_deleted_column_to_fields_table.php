<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%fields}}`.
 */
class m211021_064441_add_deleted_column_to_fields_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%fields}}', 'deleted', $this->boolean()->defaultValue(false));
        $this->addColumn('{{%fields}}', 'deleted_at', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%fields}}', 'deleted');
        $this->dropColumn('{{%fields}}', 'deleted_at');
    }
}
