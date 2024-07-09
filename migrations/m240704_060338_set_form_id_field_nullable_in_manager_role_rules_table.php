<?php

use yii\db\Migration;

/**
 * Class m240704_060338_set_form_id_field_nullable_in_manager_role_rules_table
 */
class m240704_060338_set_form_id_field_nullable_in_manager_role_rules_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('{{%fk-manager_role_rules-form_id}}','{{%manager_role_rules}}');        
        $this->alterColumn('{{%manager_role_rules}}', 'form_id', $this->integer()->unsigned()->null()); 
        $this->addColumn('{{%manager_role_rules}}', 'exhibition_id', $this->integer()->unsigned()->null()->comment('Выставка'));
       
        $this->createIndex(
            'idx-manager_role_rules_exhibition_id',
            '{{%manager_role_rules}}',
            'exhibition_id'
        );      
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-manager_role_rules_exhibition_id','{{%manager_role_rules}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240704_060338_set_form_id_field_nullable_in_manager_role_rules_table cannot be reverted.\n";

        return false;
    }
    */
}
