<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%contracts}}`.
 */
class m221128_085347_add_any_column_to_contracts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%contracts}}', 'hall_id', $this->integer()->comment('Зал'));
        $this->addColumn('{{%contracts}}', 'stand_number_id', $this->integer()->comment('Номер стенда'));
        $this->addColumn('{{%contracts}}', 'stand_square', $this->integer()->comment('Площадь стенда'));
    
        $this->createIndex(
            'idx-contracts_hall_id',
            '{{%contracts}}',
            'hall_id'
            );        
        $this->addForeignKey(
            '{{%fk-contracts_hall_id}}', 
            '{{%contracts}}', 
            'hall_id', 
            '{{%hall}}', 
            'id',
            'CASCADE');     
        
        $this->createIndex(
            'idx-contracts_stand_number_id',
            '{{%contracts}}',
            'stand_number_id'
            );        
        $this->addForeignKey(
            '{{%fk-contracts_stand_number_id}}', 
            '{{%contracts}}', 
            'stand_number_id', 
            '{{%stand_number}}', 
            'id',
            'CASCADE');         
    }        

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-contracts_hall_id}}','{{%contracts}}');
        $this->dropForeignKey('{{%fk-contracts_stand_number_id}}','{{%contracts}}');
        $this->dropIndex('idx-contracts_stand_number_id','{{%contracts}}');
        $this->dropIndex('idx-contracts_hall_id','{{%contracts}}');
        $this->dropColumn('{{%contracts}}', 'hall_id');
        $this->dropColumn('{{%contracts}}', 'stand_number_id');
        $this->dropColumn('{{%contracts}}', 'stand_square');
    }
}
