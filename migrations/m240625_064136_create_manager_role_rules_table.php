<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%manager_role_rules}}`.
 */
class m240625_064136_create_manager_role_rules_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%manager_role_rules}}', [
            'id' => $this->primaryKey(),
            'role_id' => $this->integer()->notNull()->comment('Id роли'),
            'form_id' => $this->integer()->notNull()->comment('Id формы'),
            'r_view' => $this->boolean()->notNull()->defaultValue(false)->comment('Просмотр заявок'),
            'r_accept' => $this->boolean()->notNull()->defaultValue(false)->comment('Принять/отклонить заявку'),
            'r_publicate' => $this->boolean()->notNull()->defaultValue(false)->comment('Опубликовать заявку'),
            'r_pay' => $this->boolean()->notNull()->defaultValue(false)->comment('Изменение статуса оплаты'),
            'r_delete' => $this->boolean()->notNull()->defaultValue(false)->comment('Удаление заявок'),
        ]);
        $this->createIndex(
            'idx-manager_role_rules_role_id',
            '{{%manager_role_rules}}',
            'role_id'
        );
        $this->addForeignKey(
            '{{%fk-manager_role_rules-role_id}}',
            '{{%manager_role_rules}}',
            'role_id',
            '{{%manager_roles}}',
            'id',
            'CASCADE'
        );        
        $this->createIndex(
            'idx-manager_role_rules_form_id',
            '{{%manager_role_rules}}',
            'form_id'
        );
        $this->addForeignKey(
            '{{%fk-manager_role_rules-form_id}}',
            '{{%manager_role_rules}}',
            'form_id',
            '{{%forms}}',
            'id',
            'CASCADE'
        );        
    }
    
    

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-manager_role_rules-role_id}}','{{%manager_role_rules}}');
        $this->dropForeignKey('{{%fk-manager_role_rules-form_id}}','{{%manager_role_rules}}');
        $this->dropIndex('idx-manager_role_rules_role_id','{{%manager_role_rules}}');
        $this->dropIndex('idx-manager_role_rules_form_id','{{%manager_role_rules}}');
        $this->dropTable('{{%manager_role_rules}}');
    }
}
