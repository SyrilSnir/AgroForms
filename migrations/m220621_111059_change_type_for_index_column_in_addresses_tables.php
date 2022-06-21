<?php

use yii\db\Migration;

/**
 * Class m220621_111059_change_type_for_index_column_in_addresses_tables
 */
class m220621_111059_change_type_for_index_column_in_addresses_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%legal_addresses}}', 'index', $this->string());
        $this->alterColumn('{{%postal_addresses}}', 'index', $this->string());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220621_111059_change_type_for_index_column_in_addresses_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220621_111059_change_type_for_index_column_in_addresses_tables cannot be reverted.\n";

        return false;
    }
    */
}
