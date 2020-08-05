<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%member_profile}}`.
 */
class m200805_095852_drop_member_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('{{%member_profile}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('{{%member_profile}}', [
            'id' => $this->primaryKey(),
        ]);
    }
}
