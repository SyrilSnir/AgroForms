<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%fields}}`.
 */
class m220228_082624_add_showed_in_request_column_to_fields_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%fields}}', 'showed_in_request', $this->boolean()->defaultValue(true)->comment('Отображать в заявке'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%fields}}', 'showed_in_request');
    }
}
