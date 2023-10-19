<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%catalog_countries}}`.
 */
class m231018_113158_create_catalog_countries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%catalog_countries}}', [
            'catalog_id' => $this->integer()->notNull()->comment('Запись в каталоге'),
            'country_id' => $this->integer()->notNull()->comment('ID страны'),
            'PRIMARY KEY (catalog_id,country_id)'            
        ]);
        
        // add foreign key for table `{{%company}}`
        $this->addForeignKey(
            '{{%fk-catalog_countries-catalog_id}}',
            '{{%catalog_countries}}',
            'catalog_id',
            '{{%catalog}}',
            'id',
            'CASCADE'
        );         
        $this->addForeignKey(
            '{{%fk-catalog_countries-country_id}}',
            '{{%catalog_countries}}',
            'country_id',
            '{{%countries}}',
            'id',
            'CASCADE'
        );         
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-catalog_countries-catalog_id}}', '{{%catalog_countries}}');
        $this->dropForeignKey('{{%fk-catalog_countries-country_id}}', '{{%catalog_countries}}');        
        $this->dropTable('{{%catalog_countries}}');
    }
}
