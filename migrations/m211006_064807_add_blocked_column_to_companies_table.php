<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%companies}}`.
 */
class m211006_064807_add_blocked_column_to_companies_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%companies}}', 'blocked', $this->boolean()->defaultValue(false)->comment('Заблокирован'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%companies}}', 'blocked');
    }
}
