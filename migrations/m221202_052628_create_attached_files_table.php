<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%attached_files}}`.
 */
class m221202_052628_create_attached_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%attached_files}}', [
            'id' => $this->primaryKey(),
            'request_id' => $this->integer()->notNull()->comment('Заявка'),
            'field_id' => $this->integer()->notNull()->comment('Поле формы'),
            'file_name' => $this->string()->notNull()->comment('Имя файла'),                
        ]);
        
        $this->createIndex(
            'idx-attached_files_request_id',
            '{{%attached_files}}',
            'request_id'
            );        
        $this->addForeignKey(
            '{{%fk-attached_files_request_id}}', 
            '{{%attached_files}}', 
            'request_id', 
            '{{%requests}}', 
            'id',
            'CASCADE');     
        
        $this->createIndex(
            'idx-attached_files_field_id',
            '{{%attached_files}}',
            'field_id'
            );       
        $this->addForeignKey(
            '{{%fk-attached_files_field_id}}', 
            '{{%attached_files}}', 
            'field_id', 
            '{{%fields}}', 
            'id',
            'CASCADE');        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-attached_files_field_id}}','{{%attached_files}}');
        $this->dropForeignKey('{{%fk-attached_files_request_id}}','{{%attached_files}}');
        $this->dropIndex('idx-attached_files_field_id','{{%attached_files}}');
        $this->dropIndex('idx-attached_files_request_id','{{%attached_files}}');        
        $this->dropTable('{{%attached_files}}');
    }
}
