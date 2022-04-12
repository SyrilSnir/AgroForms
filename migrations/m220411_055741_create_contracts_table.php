<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contracts}}`.
 */
class m220411_055741_create_contracts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contracts}}', [
            'id' => $this->primaryKey(),
            'number' => $this->string()->notNull()->comment('Номер договора'),
            'company_id' => $this->integer()->notNull()->comment('Компания'),
            'date' => $this->integer()->notNull()->comment('Дата заключения договора'),
            'status' => $this->integer()->notNull()->comment('Статус договора')
        ]);
        
        // creates index for column `company_id`
        $this->createIndex(
            '{{%idx-contracts-company_id}}',
            '{{%contracts}}',
            'company_id'
        ); 
        
        // add foreign key for table `{{%company}}`
        $this->addForeignKey(
            '{{%fk-contracts-company_id}}',
            '{{%contracts}}',
            'company_id',
            '{{%companies}}',
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
            '{{%fk-contracts-company_id}}',
            '{{%contracts}}'
        );

        // drops index for column `company_id`
        $this->dropIndex(
            '{{%idx-contracts-company_id}}',
            '{{%contracts}}'
        );        
        $this->dropTable('{{%contracts}}');
    }
}
