<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%users}}`.
 */
class m240709_120057_add_role_id_column_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%users}}', 'role_id', $this->integer()->comment('Роль менеджера'));
        $this->createIndex(
            'idx-users_role_id',
            '{{%users}}',
            'role_id'
        );
        $this->addForeignKey(
            '{{%fk-users-role_id}}',
            '{{%users}}',
            'role_id',
            '{{%manager_roles}}',
            'id',
            'CASCADE'
        );         
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-users-role_id}}','{{%users}}');
        $this->dropIndex('idx-users_role_id','{{%users}}');
        $this->dropColumn('{{%users}}', 'role_id');
    }
}
