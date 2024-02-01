<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%equipment_prices}}`.
 */
class m240131_121409_add_deleted_column_to_equipment_prices_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%equipment_prices}}', 'deleted', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%equipment_prices}}', 'deleted');
    }
}
