<?php

use yii\db\Migration;

/**
 * Class m240716_080632_add_rubricator_rules_fields_to_manager_roles_table
 */
class m240716_080632_add_rubricator_rules_fields_to_manager_roles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%manager_roles}}','r_view', $this->boolean()->comment('Просмотр рубрикатора'));
        $this->addColumn('{{%manager_roles}}','r_create', $this->boolean()->comment('Создание раздела рубрикатора'));
        $this->addColumn('{{%manager_roles}}','r_edit', $this->boolean()->comment('Редактирование раздела рубрикатора'));
        $this->addColumn('{{%manager_roles}}','r_delete', $this->boolean()->comment('Удаление раздела рубрикатора'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%manager_roles}}','r_view');
        $this->dropColumn('{{%manager_roles}}','r_create');
        $this->dropColumn('{{%manager_roles}}','r_edit');
        $this->dropColumn('{{%manager_roles}}','r_delete');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240716_080632_add_rubricator_rules_fields_to_manager_roles_table cannot be reverted.\n";

        return false;
    }
    */
}
