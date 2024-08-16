<?php

use yii\db\Migration;

/**
 * Class m240816_061516_rename_catalog_countries_table_to_catalog_addresses_table
 */
class m240816_061516_rename_catalog_countries_table_to_catalog_addresses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('{{%fk-catalog_countries-catalog_id}}', '{{%catalog_countries}}');
        $this->dropForeignKey('{{%fk-catalog_countries-country_id}}', '{{%catalog_countries}}'); 
        $this->renameTable('{{%catalog_countries}}', '{{%catalog_addresses}}');
        
        $this->addForeignKey(
            '{{%fk-catalog_addresses-catalog_id}}',
            '{{%catalog_addresses}}',
            'catalog_id',
            '{{%catalog}}',
            'id',
            'CASCADE'
        );         
        $this->addForeignKey(
            '{{%fk-catalog_addresses-country_id}}',
            '{{%catalog_addresses}}',
            'country_id',
            '{{%countries}}',
            'id',
            'CASCADE'
        ); 

        $this->addColumn('{{%catalog_addresses}}', 'region', $this->string()->comment('Регион'));
        $this->addColumn('{{%catalog_addresses}}', 'city', $this->string()->comment('Город'));
        $this->addColumn('{{%catalog_addresses}}', 'address', $this->string()->comment('Адрес'));
        $this->addColumn('{{%catalog_addresses}}', 'index', $this->string()->comment('Индекс'));
        
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240816_061516_rename_catalog_countries_table_to_catalog_addresses_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240816_061516_rename_catalog_countries_table_to_catalog_addresses_table cannot be reverted.\n";

        return false;
    }
    */
}
