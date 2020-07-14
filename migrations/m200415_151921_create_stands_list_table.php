<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stands_list}}`.
 */
class m200415_151921_create_stands_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%stands_list}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Название'),
            'description' => $this->text()->comment('Описание'),
            'photo' => $this->string()->comment('Имя оригинального файла с изображением'),
            'image_path' => $this->string()->comment('Путь к файлу с изображением'),
            'image_url' => $this->string()->comment('Url файла с изображением'), 
            'plan_path' => $this->string()->comment('Путь к файлу с планом стенда'),
            'price' => $this->integer()->notNull()->comment('Цена за м2'),
            'free_digits' => $this->integer()->comment('Количество бесплатных знаков'),
            'digit_price' => $this->integer()->notNull()->comment('Стоимость символа')   
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%stands_list}}');
    }
}
