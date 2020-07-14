<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%fields}}`.
 */
class m200608_093258_drop_field_type_id_column_from_fields_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%fields}}', 'field_type_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%fields}}', 'field_type_id', $this->integer());
    }
}
