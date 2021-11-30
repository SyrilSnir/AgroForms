<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%feedback_form}}`.
 */
class m211130_100440_create_feedback_form_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%feedback_form}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->comment('Id пользователя'),
            'message' => $this->text(),
            'created_at' => $this->integer()->unsigned()->notNull(),            
        ]);
        $this->createIndex(
            'idx-feedback_form-user_id',
            '{{%feedback_form}}',
            'user_id'
            );        
        $this->addForeignKey(
            '{{%fk-feedback_form-user_id}}', 
            '{{%feedback_form}}', 
            'user_id', 
            '{{%users}}', 
            'id',
            'CASCADE');         
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-feedback_form-user_id', '{{%feedback_form}}');
        $this->dropIndex(
            'idx-feedback_form-user_id',
            '{{%feedback_form}}'
            );        
        $this->dropTable('{{%feedback_form}}');
    }
}
