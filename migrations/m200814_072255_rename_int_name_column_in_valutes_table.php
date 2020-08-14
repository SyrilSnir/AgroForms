<?php

use yii\db\Migration;

/**
 * Class m200814_072255_rename_int_name_column_in_valutes_table
 */
class m200814_072255_rename_int_name_column_in_valutes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%valutes}}', 'int_name', 'name_eng');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('{{%valutes}}', 'name_eng', 'int_name');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200814_072255_rename_int_name_column_in_valutes_table cannot be reverted.\n";

        return false;
    }
    */
}
