<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%regions}}`.
 */
class m200317_144239_create_regions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%regions}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Название региона'),
            'country_id' => $this->integer()->notNull()->comment('Страна'),
        ]);
        
        $this->createIndex(
            'idx-regions-country_id',
            '{{%regions}}',
            'country_id'
        );
        
        $this->addForeignKey(
            '{{%fk-cities-region_id}}', 
            '{{%cities}}', 
            'region_id', 
            '{{%regions}}', 
            'id',
            'CASCADE');        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropIndex(
            'idx-regions-country_id',
            '{{%regions}}'
        );        
        $this->dropTable('{{%regions}}');
    }
}
