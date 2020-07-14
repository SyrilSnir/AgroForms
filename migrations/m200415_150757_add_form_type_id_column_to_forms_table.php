<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%forms}}`.
 */
class m200415_150757_add_form_type_id_column_to_forms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
                '{{%forms}}', 
                'form_type_id', 
                $this->integer()
                    ->notNull()
                    ->comment('Тип формы'));          
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%forms}}', 'form_type_id');        
    }
}
