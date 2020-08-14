<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%form_types}}`.
 */
class m200813_134623_add_columns_to_form_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%form_types}}', 'name_eng', $this->string()->comment('Название (ENG)'));
        $this->addColumn('{{%form_types}}', 'description_eng', $this->string()->comment('Описание (ENG)'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%form_types}}', 'name_eng');
        $this->dropColumn('{{%form_types}}', 'description_eng');
    }
}
