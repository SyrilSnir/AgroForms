<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%forms}}`.
 */
class m211021_064507_add_deleted_column_to_forms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%forms}}', 'deleted', $this->boolean()->defaultValue(false));
        $this->addColumn('{{%forms}}', 'deleted_at', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%forms}}', 'deleted');
        $this->dropColumn('{{%forms}}', 'deleted_at');
    }
}
