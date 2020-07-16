<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%field_enums}}`.
 */
class m200715_055736_create_field_enums_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%field_enums}}', [
            'id' => $this->primaryKey(),
            'field_id' => $this->integer()->notNull()->comment('Поле'),
            'name' => $this->string()->notNull()->comment('Название группы аттрибутов'),
            'value' => $this->string()->notNull()->comment('Значение'),            
        ]);
        $this->createIndex(
            'idx-field_enums-field_id',
            '{{%field_enums}}',
            'field_id'
            );   
        $this->addForeignKey(
            '{{%fk-field_enums-field_id}}', 
            '{{%field_enums}}', 
            'field_id', 
            '{{%fields}}', 
            'id',
            'CASCADE');          
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-field_enums-field_id', '{{%field_enums}}');        
        $this->dropIndex(
            'idx-field_enums-form_id',
            '{{%field_enums}}'
            );         
        $this->dropTable('{{%field_enums}}');
    }
}
