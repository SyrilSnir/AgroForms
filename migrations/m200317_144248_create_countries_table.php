<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%countries}}`.
 */
class m200317_144248_create_countries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%countries}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Название страны'),
            'code' => $this->string(3)->comment('Трехбуквенный код страны')
        ]);
        
        $this->addForeignKey(
            '{{%fk-regions-country_id}}', 
            '{{%regions}}', 
            'country_id', 
            '{{%countries}}', 
            'id',
            'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%countries}}');
    }
}
