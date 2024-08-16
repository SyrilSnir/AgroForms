<?php

use yii\db\Migration;

/**
 * Class m240816_075600_add_eng_fields_to_catalog_addresses_table
 */
class m240816_075600_add_eng_fields_to_catalog_addresses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%catalog_addresses}}', 'region_eng', $this->string()->comment('Регион (ENG)'));
        $this->addColumn('{{%catalog_addresses}}', 'city_eng', $this->string()->comment('Город (ENG)'));
        $this->addColumn('{{%catalog_addresses}}', 'address_eng', $this->string()->comment('Адрес (Eng)'));
        $this->addColumn('{{%catalog_addresses}}', 'zip_code', $this->string()->comment('Zip Code'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240816_075600_add_eng_fields_to_catalog_addresses_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240816_075600_add_eng_fields_to_catalog_addresses_table cannot be reverted.\n";

        return false;
    }
    */
}
