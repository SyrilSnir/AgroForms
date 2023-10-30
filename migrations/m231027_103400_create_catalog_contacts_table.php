<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%catalog_contacts}}`.
 */
class m231027_103400_create_catalog_contacts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%catalog_contacts}}', [
            'id' => $this->primaryKey(),
            'catalog_id' => $this->integer()->notNull()->comment('Запись в каталоге'),
            'site' => $this->string()->comment('Сайт'),
            'email' => $this->string()->comment('Email'),
            'phone' => $this->string()->comment('Телефон'),
        ]);
        $this->createIndex(
            '{{%idx-catalog_contacts-catalog_id}}',
            '{{%catalog_contacts}}',
            'catalog_id'
        );   
        
        $this->addForeignKey(
            '{{%fk-catalog_contacts-catalog_id}}',
            '{{%catalog_contacts}}',
            'catalog_id',
            '{{%catalog}}',
            'id',
            'CASCADE'
        );         
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-catalog_contacts-catalog_id}}', '{{%catalog_contacts}}');
        $this->dropIndex('{{%idx-catalog_contacts-catalog_id}}', '{{%catalog_contacts}}');
        $this->dropTable('{{%catalog_contacts}}');
    }
}
