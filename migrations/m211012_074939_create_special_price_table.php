<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%special_price}}`.
 */
class m211012_074939_create_special_price_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%special_price}}', [
            'id' => $this->primaryKey(),
            'field_id' => $this->integer(),
            'start_date' => $this->date(),
            'end_date' => $this->date(),
            'price' => $this->integer(),
        ]);
        $this->createIndex(
            '{{idx-special_price-field_id}}',
            '{{%special_price}}',
            'field_id'
        );  
        
        $this->addForeignKey(
            '{{fk-special_price-field_id}}',
            '{{%special_price}}',
            'field_id',
            '{{%fields}}',
            'id',
            'CASCADE'
        );         
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
     
        $this->dropForeignKey(
            '{{fk-special_price-field_id}}',
            '{{%special_price}}');          
        $this->dropIndex(
            '{{idx-special_price-field_id}}',
            '{{%special_price}}');
       
        $this->dropTable('{{%special_price}}');
    }
}
