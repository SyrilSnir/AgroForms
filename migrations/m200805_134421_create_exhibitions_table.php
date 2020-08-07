<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%exhibitions}}`.
 */
class m200805_134421_create_exhibitions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%exhibitions}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->comment('Заголовок'),
            'title_eng' => $this->string()->comment('Заголовок (ENG)'),
            'description' => $this->string()->comment('Описание'),
            'description_eng' => $this->string()->comment('Описание (ENG)'),
            'start_date' => $this->integer()->notNull()->comment('Дата начала'),
            'end_date' => $this->integer()->notNull()->comment('Дата окончания'),
            'status' => $this->tinyInteger()->notNull()->defaultValue(0)->comment('Статус'),
        ]);
    }    

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%exhibitions}}');
    }
}
