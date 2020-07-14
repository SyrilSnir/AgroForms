<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%requests}}`.
 */
class m200427_075544_create_requests_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%requests}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->comment('Заказчик'),
            'form_type_id' => $this->integer()->notNull()->comment('Тип формы'),
            'status' => $this->integer()->notNull('Статус'),
            'created_at' => $this->integer()->unsigned()->notNull()
        ]);
        $this->createIndex(
            'idx-requests-user_id',
            '{{%requests}}',
            'user_id'
            );
        $this->createIndex(
            'idx-requests-form_type_id',
            '{{%requests}}',
            'form_type_id'
            );
        $this->addForeignKey(
            '{{%fk-requests-user_id}}', 
            '{{%requests}}', 
            'user_id', 
            '{{%users}}', 
            'id',
            'CASCADE'); 
        $this->addForeignKey(
            '{{%fk-requests-form_type_id}}', 
            '{{%requests}}', 
            'form_type_id', 
            '{{%form_types}}', 
            'id',
            'CASCADE');          
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-requests-user_id', 'requests');
        $this->dropForeignKey('fk-requests-form_type_id', 'requests');
        $this->dropIndex(
            'idx-requests-user_id',
            '{{%requests}}'
            );
        $this->dropIndex(
            'idx-requests-form_type_id',
            '{{%requests}}'
            );          
        $this->dropTable('{{%requests}}');
    }
}
