<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%field_types}}`.
 */
class m200415_151843_create_field_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%field_types}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->comment('Название'),
            'description' => $this->string()->comment('Описание'),
            
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%field_types}}');
    }
}
