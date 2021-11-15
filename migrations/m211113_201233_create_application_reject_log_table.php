<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%application_reject_log}}`.
 */
class m211113_201233_create_application_reject_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%application_reject_log}}', [
            'id' => $this->primaryKey(),
            'request_id' => $this->integer()->notNull()->comment('Id заявки'),
            'comment' => $this->text()->comment('Комментарий'),
            'actual' => $this->boolean()->notNull()->defaultValue(true)->comment('Актуальность'),
            'date' => $this->dateTime()->notNull()->comment('Дата')
        ]);
        
        $this->createIndex(
            '{{idx-application_reject_log-request_id}}',
            '{{%application_reject_log}}',
            'request_id'
        );
        $this->addForeignKey(
            '{{fk-application_reject_log-request_id}}',
            '{{%application_reject_log}}',
            'request_id',
            '{{%requests}}',
            'id',
            'CASCADE'
        );        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            '{{fk-application_reject_log-request_id}}',
            '{{%application_reject_log}}');          
        $this->dropIndex(
            '{{idx-application_reject_log-request_id}}',
            '{{%application_reject_log}}');        
        $this->dropTable('{{%application_reject_log}}');
    }
}
