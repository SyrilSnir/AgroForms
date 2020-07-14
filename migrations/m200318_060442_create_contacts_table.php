<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contacts}}`.
 */
class m200318_060442_create_contacts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contacts}}', [
            'id' => $this->primaryKey(),
            'chief_position' => $this->string()->notNull()->comment('Дожность руководителя'),
            'chief_fio' => $this->string()->notNull()->comment('ФИО руководителя'),
            'chief_phone' => $this->string()->notNull()->comment('Телефон руководителя'),
            'chief_email' => $this->string()->notNull()->comment('Email руководителя'),
            'manager_position' => $this->string()->notNull()->comment('Должность менеджера'),
            'manager_fio' => $this->string()->notNull()->comment('ФИО менеджера'),
            'manager_phone' => $this->string()->notNull()->comment('Телефон менеджера'),
            'manager_fax' => $this->string()->comment('Факс менеджера'),
            'manager_email' => $this->string()->notNull()->comment('Email менеджера'),
        ]);
        
        $this->addForeignKey(
                    '{{%fk-companies-contacts_id}}',
                    '{{%companies}}', 
                    'contacts_id', 
                    '{{%contacts}}', 
                    'id',
                    'CASCADE'
                );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%contacts}}');
    }
}
