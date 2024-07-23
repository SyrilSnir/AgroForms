<?php

use yii\db\Migration;

/**
 * Class m240723_115442_add_catalog_rules_fields_to_manager_roles_table
 */
class m240723_115442_add_catalog_rules_fields_to_manager_roles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%manager_roles}}','catalog_view', $this->boolean()->comment('Просмотр каталога'));
        $this->addColumn('{{%manager_roles}}','catalog_load', $this->boolean()->comment('Загрузка данных'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%manager_roles}}','catalog_view');
        $this->dropColumn('{{%manager_roles}}','catalog_load');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240723_115442_add_catalog_rules_fields_to_manager_roles_table cannot be reverted.\n";

        return false;
    }
    */
}
