<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%postal_addresses}}`.
 */
class m200317_155752_create_postal_addresses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%postal_addresses}}', [
            'id' => $this->primaryKey(),
            'index' => $this->integer()->comment('Почтовый индекс'),
            'city_id' => $this->integer()->notNull()->comment('Город'),            
            'address' => $this->string()->notNull()->comment('Улица, дом')            
        ]);
        
        $this->addForeignKey(
                    '{{%fk-companies-postal_address_id}}',
                    '{{%companies}}', 
                    'postal_address_id', 
                    '{{%postal_addresses}}', 
                    'id',
                    'CASCADE'
                );        
        $this->createIndex(
                'idx-postal_addresses-city_id',
                '{{%postal_addresses}}',
                'city_id'
                );        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-postal_addresses-city_id',
            '{{%postal_addresses}}'
        );
        $this->dropTable('{{%postal_addresses}}');
    }
}
