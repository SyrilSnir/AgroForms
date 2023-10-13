<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%catalog}}`.
 */
class m231012_095936_create_catalog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%catalog}}', [
            'id' => $this->primaryKey(),
            'exhibition_id'  => $this->integer()->comment('Выставка'),
            'logo_file'  => $this->string()->comment('Файл логотипа'),
            'company'  => $this->string()->comment('Компания'),
            'company_eng'  => $this->string()->comment('Компания (ENG)'),
            'country'  => $this->string()->comment('Страна'),
            'country_eng'  => $this->string()->comment('Страна (ENG)'),            
            'description'  => $this->text()->comment('Описание'),
            'description_eng'  => $this->text()->comment('Описание (ENG)'),            
        ]);
        // creates index for column `exhibition_id`
        $this->createIndex(
            '{{%idx-catalog-exhibition_id}}',
            '{{%catalog}}',
            'exhibition_id'
        ); 
        
        // add foreign key for table `{{%company}}`
        $this->addForeignKey(
            '{{%fk-catalog-exhibition_id}}',
            '{{%catalog}}',
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
        // drops foreign key for table `{{%catalog}}`
        $this->dropForeignKey(
            '{{%fk-catalog-exhibition_id}}',
            '{{%catalog}}'
        );

        // drops index for column `contract_id`
        $this->dropIndex(
            '{{%idx-catalog-exhibition_id}}',
            '{{%catalog}}'
        );        
        $this->dropTable('{{%catalog}}');
    }
}
