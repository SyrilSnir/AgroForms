<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%equipment_groups}}`.
 */
class m200317_111835_create_equipment_groups_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%equipment_groups}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Категория'),
            'description' => $this->string()->comment('Описание')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%equipment_groups}}');
    }
}
