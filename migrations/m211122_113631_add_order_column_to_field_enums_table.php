<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%field_enums}}`.
 */
class m211122_113631_add_order_column_to_field_enums_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%field_enums}}', 'order', $this->integer()->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%field_enums}}', 'order');
    }
}
