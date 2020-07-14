<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%member_profile}}`.
 */
class m200419_112751_create_member_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%member_profile}}', [
            'user_id' => $this->primaryKey(),
            'position' => $this->string()->comment('Должность'),
            'activities' => $this->string()->comment('Сфера деятельности компании'),
            'proposal_signature_post' => $this->string()->comment('Должность подписанта'),
            'proposal_signature_name' => $this->string()->comment('ФИО подписанта'),
            
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%member_profile}}');
    }
}
