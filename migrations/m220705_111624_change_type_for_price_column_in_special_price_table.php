<?php

use yii\db\Migration;

/**
 * Class m220705_111624_change_type_for_price_column_in_special_price_table
 */
class m220705_111624_change_type_for_price_column_in_special_price_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%special_price}}', 'price', $this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220705_111624_change_type_for_price_column_in_special_price_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220705_111624_change_type_for_price_column_in_special_price_table cannot be reverted.\n";

        return false;
    }
    */
}
