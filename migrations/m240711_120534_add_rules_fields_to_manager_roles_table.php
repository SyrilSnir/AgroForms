<?php

use yii\db\Migration;

/**
 * Class m240711_120534_add_rules_fields_to_manager_roles_table
 */
class m240711_120534_add_rules_fields_to_manager_roles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%manager_roles}}','u_view', $this->boolean()->comment('Просмотр пользователей'));
        $this->addColumn('{{%manager_roles}}','u_create', $this->boolean()->comment('Создание пользователей'));
        $this->addColumn('{{%manager_roles}}','u_edit', $this->boolean()->comment('Редактирование пользователей'));
        $this->addColumn('{{%manager_roles}}','u_delete', $this->boolean()->comment('Удаление пользователей'));
        
        $this->addColumn('{{%manager_roles}}','c_view', $this->boolean()->comment('Просмотр компаний'));
        $this->addColumn('{{%manager_roles}}','c_create', $this->boolean()->comment('Создание компаний'));
        $this->addColumn('{{%manager_roles}}','c_edit', $this->boolean()->comment('Редактирование компаний'));
        $this->addColumn('{{%manager_roles}}','c_delete', $this->boolean()->comment('Удаление компаний'));
        
        $this->addColumn('{{%manager_roles}}','d_view', $this->boolean()->comment('Просмотр документов'));
        $this->addColumn('{{%manager_roles}}','d_create', $this->boolean()->comment('Создание документов'));
        $this->addColumn('{{%manager_roles}}','d_edit', $this->boolean()->comment('Редактирование документов'));
        $this->addColumn('{{%manager_roles}}','d_delete', $this->boolean()->comment('Удаление документов'));
        
        $this->addColumn('{{%manager_roles}}','co_view', $this->boolean()->comment('Просмотр договоров'));
        $this->addColumn('{{%manager_roles}}','co_create', $this->boolean()->comment('Редактирование договоров'));
        $this->addColumn('{{%manager_roles}}','co_edit', $this->boolean()->comment('Редактирование договоров'));
        $this->addColumn('{{%manager_roles}}','co_delete', $this->boolean()->comment('Редактирование договоров'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%manager_roles}}','u_view');
        $this->dropColumn('{{%manager_roles}}','u_create');
        $this->dropColumn('{{%manager_roles}}','u_edit');
        $this->dropColumn('{{%manager_roles}}','u_delete');
        
        $this->dropColumn('{{%manager_roles}}','c_view');
        $this->dropColumn('{{%manager_roles}}','c_create');
        $this->dropColumn('{{%manager_roles}}','c_edit');
        $this->dropColumn('{{%manager_roles}}','c_delete');
        
        $this->dropColumn('{{%manager_roles}}','d_view');
        $this->dropColumn('{{%manager_roles}}','d_create');
        $this->dropColumn('{{%manager_roles}}','d_edit');
        $this->dropColumn('{{%manager_roles}}','d_delete');
        
        $this->dropColumn('{{%manager_roles}}','co_view');
        $this->dropColumn('{{%manager_roles}}','co_create');
        $this->dropColumn('{{%manager_roles}}','co_edit');
        $this->dropColumn('{{%manager_roles}}','co_delete');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240711_120534_add_rules_fields_to_manager_roles_table cannot be reverted.\n";

        return false;
    }
    */
}
