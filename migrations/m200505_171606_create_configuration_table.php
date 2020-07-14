<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%configuration}}`.
 */
class m200505_171606_create_configuration_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->createTable('{{%configuration}}', [
            'id' => $this->primaryKey(),
            'section' => $this->string()->notNull()->comment('Раздел'),
            'name' => $this->string()->notNull()->comment('Название настройки'),
            'value' => $this->string()->notNull()->comment('Значение'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       // $this->dropTable('{{%configuration}}');
    }
}
