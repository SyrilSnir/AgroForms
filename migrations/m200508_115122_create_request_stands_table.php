<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%request_stands}}`.
 */
class m200508_115122_create_request_stands_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%request_stands}}', [
            'id' => $this->primaryKey(),
            'stand_id' => $this->integer()->notNull()->comment('Тип стенда'),
            'request_id' => $this->integer()->notNull()->comment('Id заявки'),
            'width' => $this->integer()->comment('Ширина'),
            'length' => $this->integer()->comment('Длинна'),
            'square' => $this->integer()->notNull()->comment('Площадь'),
            'frizeName' => $this->string()->comment('Фризовая надпись'),
            'stand_price' => $this->integer()->notNull()->comment('Цена за м2'),
            'frize_price' => $this->integer()->notNull()->comment('Стоимость фризовой надписи'),
            'amount' => $this->integer()->notNull()->comment('Стоимость'),
            'file' => $this->string()->comment('Файл, приложенный к форме'),         
        ]);
        $this->createIndex(
            'idx-request_stands-request_id',
            '{{%request_stands}}',
            'request_id'
            );        
        $this->createIndex(
            'idx-request_stands-stand_id',
            '{{%request_stands}}',
            'stand_id'
            );        
        $this->addForeignKey(
            '{{%fk-request_stands-request_id}}', 
            '{{%request_stands}}', 
            'request_id', 
            '{{%requests}}', 
            'id',
            'CASCADE');        
        $this->addForeignKey(
            '{{%fk-request_stands-stand_id}}', 
            '{{%request_stands}}', 
            'stand_id', 
            '{{%stands_list}}', 
            'id',
            'CASCADE');           
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-request_stands-request_id', 'request_stands');
        $this->dropForeignKey('fk-request_stands-stand_id', 'request_stands');
        $this->dropIndex(
            'idx-request_stands-request_id',
            '{{%request_stands}}'
            );          
        $this->dropIndex(
            'idx-request_stands-stand_id',
            '{{%request_stands}}'
            );  
        $this->dropTable('{{%request_stands}}');
    }
}
