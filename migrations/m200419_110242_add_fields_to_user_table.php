<?php

use yii\db\Migration;

/**
 * Class m200419_110242_add_fields_to_user_table
 */
class m200419_110242_add_fields_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
                '{{%users}}', 
                'genre', 
                $this->integer()
                    ->notNull()
                    ->defaultValue(0)
                    ->comment('Пол')
        );
        $this->addColumn(
                '{{%users}}', 
                'language', 
                $this->integer()
                    ->notNull()
                    ->defaultValue(1)
                    ->comment('Язык')
        );        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%users}}', 'genre');        
        $this->dropColumn('{{%users}}', 'language');        
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200419_110242_add_fields_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
