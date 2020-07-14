<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%legal_addresses}}`.
 */
class m200317_155739_create_legal_addresses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%legal_addresses}}', [
            'id' => $this->primaryKey(),
            'index' => $this->integer()->comment('Почтовый индекс'),
            'city_id' => $this->integer()->notNull()->comment('Город'),            
            'address' => $this->string()->notNull()->comment('Улица, дом')
        ]);
        
        $this->addForeignKey(
                    '{{%fk-companies-legal_address_id}}',
                    '{{%companies}}', 
                    'legal_address_id', 
                    '{{%legal_addresses}}', 
                    'id',
                    'CASCADE'
                );
        $this->createIndex(
                'idx-legal_addresses-city_id',
                '{{%legal_addresses}}',
                'city_id'
                );
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-legal_addresses-city_id',
            '{{%legal_addresses}}'
        );
        $this->dropTable('{{%legal_addresses}}');
    }
}
