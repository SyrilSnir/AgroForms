<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%companies}}`.
 */
class m200317_143510_create_companies_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%companies}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Название'),
            'full_name' => $this->string()->notNull()->comment('Полное наименование'),
            'inn' => $this->string()->notNull()->comment('ИНН'),
            'kpp' => $this->string()->notNull()->comment('КПП'),
            'phone' => $this->string()->notNull()->comment('Телефон'),
            'fax' => $this->string()->comment('Факс'),
            'site' => $this->string()->comment('Сайт'),
            'contacts_id' => $this->integer()->notNull()->comment('Контакты'),
            'bank_details_id' => $this->integer()->notNull()->comment('Банковские реквизиты'),
            'postal_address_id' => $this->integer()->notNull()->comment('Почтовый адрес'),
            'legal_address_id' => $this->integer()->notNull()->comment('Юридический адрес'),
            'image_path' => $this->string()->comment('Путь к файлу с изображением'),
            'image_url' => $this->string()->comment('Url файла с изображением'),
            'deleted' => $this->boolean()->notNull()->defaultValue(false) 
        ]);
        
        $this->createIndex(
            'idx-companies-contacts_id',
            '{{%companies}}',
            'contacts_id'
            );
        $this->createIndex(
            'idx-companies-bank_details_id',
            '{{%companies}}',
            'bank_details_id'
            );
        $this->createIndex(
            'idx-companies-postal_address_id',
            '{{%companies}}',
            'postal_address_id'
            );
        $this->createIndex(
            'idx-companies-legal_address_id',
            '{{%companies}}',
            'legal_address_id'
            );        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-companies-contacts_id',
            '{{%companies}}'
            );
        $this->dropIndex(
            'idx-companies-bank_details_id',
            '{{%companies}}'
            );        
        $this->dropIndex(
            'idx-companies-bpostal_address_id',
            '{{%companies}}'
            );
        $this->dropIndex(
            'idx-companies-legal_address_id',
            '{{%companies}}'
            );         
        $this->dropTable('{{%companies}}');
    }
}
