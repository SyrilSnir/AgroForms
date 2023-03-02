<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%rubricator}}`.
 */
class m230302_082925_add_deleted_column_to_rubricator_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%rubricator}}', 'deleted', $this->boolean()->defaultValue(false));        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%rubricator}}', 'deleted');        
    }
}
