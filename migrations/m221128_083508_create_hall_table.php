<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%hall}}`.
 */
class m221128_083508_create_hall_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%hall}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->comment('Название'),
            'name_eng' => $this->string()->comment('Название (ENG)')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%hall}}');
    }
}
