<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%units}}`.
 */
class m200317_111334_create_units_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%units}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Наминование'),
            'short_name' => $this->string()->comment('Краткое наименование'),            
        ]);
        $this->addForeignKey(
                '{{%fk-additional_equipment-unit_id}}', 
                '{{%additional_equipment}}', 
                'unit_id', 
                '{{%units}}', 
                'id',
                'CASCADE'
                );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%units}}');
    }
}
