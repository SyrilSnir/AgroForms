<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%request_dynamic_forms}}`.
 */
class m200623_122446_create_request_dynamic_forms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%request_dynamic_forms}}', [
            'id' => $this->primaryKey(),
            'request_id' => $this->integer()->notNull()->comment('Id заявки'),
            'amount' => $this->integer()->notNull()->defaultValue(0)->comment('Стоимость'),            
            'fields' => $this->text()->comment('Данные формы')
        ]);
        $this->createIndex(
            'idx-request_dynamic_forms-request_id',
            '{{%request_dynamic_forms}}',
            'request_id'
            );   
        $this->addForeignKey(
            '{{%fk-request_dynamic_forms-request_id}}', 
            '{{%request_dynamic_forms}}', 
            'request_id', 
            '{{%requests}}', 
            'id',
            'CASCADE');        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-request_dynamic_forms-request_id', 'request_dynamic_forms');
        $this->dropIndex(
            'idx-request_dynamic_forms-request_id',
            '{{%request_dynamic_forms}}'
            );                   
        $this->dropTable('{{%request_dynamic_forms}}');
    }
}
