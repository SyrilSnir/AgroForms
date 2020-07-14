<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cities}}`.
 */
class m200317_144228_create_cities_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cities}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Название города'),
            'region_id' => $this->integer()->notNull()->comment('Регион'),
        ]);
        $this->createIndex(
            'idx-cities-region_id',
            '{{%cities}}',
            'region_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-cities-region_id',
            '{{%cities}}'
        );           
        $this->dropTable('{{%cities}}');
    }
}
