<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%form_types}}`.
 */
class m200415_151707_create_form_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%form_types}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->comment('Название'),
            'description' => $this->string()->comment('Описание')    
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%form_types}}');
    }
}
