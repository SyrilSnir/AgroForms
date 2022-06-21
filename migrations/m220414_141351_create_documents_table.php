<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%documents}}`.
 */
class m220414_141351_create_documents_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%documents}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->comment('Заголовок'),
            'title_eng' => $this->string()->comment('Заголовок (ENG)'),
            'description' => $this->string()->comment('Описание'),
            'description_eng' => $this->string()->comment('Описание (ENG)'),            
            'file' => $this->string()->notNull()->comment('Файл'),            
            'exhibition_id' => $this->integer()->notNull()->comment('Выставка'),
            'company_id' => $this->integer()->notNull()->comment('Компания'),
            'created_at' => $this->integer()->notNull()->comment('Дата добавления'),                        
        ]);
        // creates index for column `company_id`
        $this->createIndex(
            '{{%idx-documents-company_id}}',
            '{{%documents}}',
            'company_id'
        ); 
        // creates index for column `exhibition_id`
        $this->createIndex(
            '{{%idx-documents-exhibition_id}}',
            '{{%documents}}',
            'exhibition_id'
        ); 
        
        // add foreign key for table `{{%companies}}`
        $this->addForeignKey(
            '{{%fk-documents-company_id}}',
            '{{%documents}}',
            'company_id',
            '{{%companies}}',
            'id',
            'CASCADE'
        ); 
        
        
        // add foreign key for table `{{%exhibitions}}`
        $this->addForeignKey(
            '{{%fk-documents-exhibition_id}}',
            '{{%documents}}',
            'exhibition_id',
            '{{%exhibitions}}',
            'id',
            'CASCADE'
        );         
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%company}}`
        $this->dropForeignKey(
            '{{%fk-documents-company_id}}',
            '{{%documents}}'
        );

        // drops foreign key for table `{{%contracts}}`
        $this->dropForeignKey(
            '{{%fk-documents-exhibition_id}}',
            '{{%documents}}'
        );
        
        // drops index for column `company_id`
        $this->dropIndex(
            '{{%idx-documents-company_id}}',
            '{{%documents}}'
        );        
        
        

        // drops index for column `exhibition_id`
        $this->dropIndex(
            '{{%idx-documents-exhibition_id}}',
            '{{%documents}}'
        );
        $this->dropTable('{{%documents}}');
    }
}
