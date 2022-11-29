<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stand_number}}`.
 */
class m221128_083524_create_stand_number_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%stand_number}}', [
            'id' => $this->primaryKey(),
            'number' => $this->string()->notNull()->comment('Номер'),                
        ]);        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%stand_number}}');
    }
}
