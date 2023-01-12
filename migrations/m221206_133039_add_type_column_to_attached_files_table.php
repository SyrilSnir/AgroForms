<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%attached_files}}`.
 */
class m221206_133039_add_type_column_to_attached_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%attached_files}}', 'type', $this->integer()->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%attached_files}}', 'type');
    }
}
