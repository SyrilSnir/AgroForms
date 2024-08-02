<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%contracts}}`.
 */
class m240801_125356_add_show_in_requests_column_to_contracts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%contracts}}', 'show_in_requests', $this->boolean()->defaultValue(true)->comment('Показывать в заявках'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%contracts}}', 'show_in_requests');
    }
}
