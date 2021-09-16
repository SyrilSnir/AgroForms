<?php

use yii\db\Migration;

/**
 * Class m210916_103158_rename_stands_table
 */
class m210916_103158_rename_stands_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameTable('{{%stands_list}}', '{{%stands}}');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameTable('{{%stands}}', '{{%stands_list}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210916_103158_rename_stands_table cannot be reverted.\n";

        return false;
    }
    */
}
