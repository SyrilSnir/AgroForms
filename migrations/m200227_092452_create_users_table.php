<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m200227_092452_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'login' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string(),
            'auth_key' => $this->string(),
            'password_reset_token' => $this->string()->unique(),
            'company_id' => $this->integer()->notNull()->comment('Компания'),            
            'user_type_id' => $this->integer()->notNull()->comment('Тип пользователя'),
            'fio' => $this->string()->comment('ФИО'),
            'email' => $this->string()->comment('Электронная почта'),
            'phone' => $this->string()->comment('Номер телефона'),
            'birthday' => $this->date()->comment('Дата рождения'),
            'avatar_path' => $this->string()->comment('Путь к файлу с аватаром'),
            'avatar_url' => $this->string()->comment('Url файла с аватаром'),
            'description' => $this->text()->comment('Дополнительная информация'),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
            'active' => $this->boolean()->notNull()->defaultValue(true), 
            'deleted' => $this->boolean()->notNull()->defaultValue(false), 
        ]);
        $this->createIndex(
            'idx-users-company_id',
            '{{%users}}',
            'company_id'
        );
        
        $this->createIndex(
            'idx-users-user_type_id',
            '{{%users}}',
            'user_type_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-users-company_id',
            '{{%users}}'
        );        
        $this->dropIndex(
            'idx-users-user_type_id',
            '{{%users}}'
        );
        $this->dropTable('{{%users}}');
    }
}
