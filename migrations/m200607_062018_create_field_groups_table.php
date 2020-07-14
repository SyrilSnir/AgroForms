<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%field_groups}}`.
 */
class m200607_062018_create_field_groups_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%field_groups}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Название группы полей'),
            'description' => $this->string()->comment('Описание'),
            'name_eng' => $this->string()->notNull()->comment('Название группы полей (ENG)'),
            'description_eng' => $this->string()->comment('Описание (ENG)'),            
            'order' => $this->integer()->comment('Порядок вывода'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%field_groups}}');
    }
}
