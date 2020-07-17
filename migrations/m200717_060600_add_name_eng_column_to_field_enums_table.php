<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%field_enums}}`.
 */
class m200717_060600_add_name_eng_column_to_field_enums_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%field_enums}}', 'name_eng', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%field_enums}}', 'name_eng');
    }
}
