<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%request_stands}}`.
 */
class m211116_130958_add_form_id_column_to_request_stands_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%request_stands}}', 'form_id', $this->integer());
        $this->createIndex(
            'idx-request_stands-form_id',
            '{{%request_stands}}',
            'form_id'
        );  
        $this->addForeignKey(
                'fk-request_stands-form_id', 
                '{{%request_stands}}', 
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
        $this->dropForeignKey('fk-request_stands-form_id', '{{%request_stands}}');
        $this->dropIndex('idx-request_stands-form_id', '{{%request_stands}}');        
        $this->dropColumn('{{%request_stands}}', 'form_id');
    }
}
