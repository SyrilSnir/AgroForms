<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%request_dynamic_form}}`.
 */
class m200717_073132_add_file_name_column_to_request_dynamic_forms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%request_dynamic_forms}}', 'file', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%request_dynamic_forms}}', 'file');
    }
}
