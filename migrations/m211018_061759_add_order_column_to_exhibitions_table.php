<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%exhibitions}}`.
 */
class m211018_061759_add_order_column_to_exhibitions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%exhibitions}}', 'order', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%exhibitions}}', 'order');
    }
}
