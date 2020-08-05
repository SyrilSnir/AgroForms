<?php

use yii\db\Migration;

/**
 * Class m200805_085627_rename_genre_column_in_users_table
 */
class m200805_085627_rename_genre_column_in_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%users}}', 'genre', 'gender');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('{{%users}}', 'gender', 'genre');        
    }
}
