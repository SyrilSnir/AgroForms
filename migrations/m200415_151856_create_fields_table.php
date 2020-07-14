<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fields}}`.
 */
class m200415_151856_create_fields_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fields}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->comment('Название'),
            'description' => $this->string()->comment('Описание'),
            'form_id' => $this->integer()->notNull()->comment('Форма'),
            'element_type_id' => $this->integer()->notNull()->comment('Тип элемента формы'),
            'field_type_id' => $this->integer()->notNull()->comment('Тип поля'),
            'order' => $this->integer()->notNull()->defaultValue(0)->comment('Позиция на экране'),
            'default_value' => $this->string()->comment('Значение по умолчанию')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%fields}}');
    }
}
