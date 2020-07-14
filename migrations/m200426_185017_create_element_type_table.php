<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%element_type}}`.
 */
class m200426_185017_create_element_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%element_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Название элемента фрормы'),
            'description' => $this->string()->comment('Описание элемента фрормы'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%element_type}}');
    }
}
