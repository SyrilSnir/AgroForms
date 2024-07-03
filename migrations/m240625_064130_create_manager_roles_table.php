<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%manager_roles}}`.
 */
class m240625_064130_create_manager_roles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%manager_roles}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Название роли'),
            'name_eng' => $this->string()->notNull()->comment('Название роли (ENG)'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%manager_roles}}');
    }
}
