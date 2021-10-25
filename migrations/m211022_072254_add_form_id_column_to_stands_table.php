<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%stands}}`.
 */
class m211022_072254_add_form_id_column_to_stands_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%stands}}', 'form_id', $this->integer());
        $this->createIndex(
            'idx-stands-form_id',
            '{{%stands}}',
            'form_id'
        );  
        $this->addForeignKey(
                'fk-stands-form_id', 
                '{{%stands}}', 
                'form_id', 
                '{{%forms}}', 
                'id',
                'CASCADE'
                );             
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-stands-form_id', '{{%stands}}');
        $this->dropIndex('idx-stands-form_id', '{{%stands}}');         
        $this->dropColumn('{{%stands}}', 'form_id');
    }
}
