<?php

use yii\db\Migration;

/**
 * Class m210916_105017_rename_frizeName_column_in_request_stands_table
 */
class m210916_105017_rename_frizeName_column_in_request_stands_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%request_stands}}', 'frizeName', 'frize_name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('{{%request_stands}}', 'frize_name', 'frizeName');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210916_105017_rename_frizeName_column_in_request_stands_table cannot be reverted.\n";

        return false;
    }
    */
}
