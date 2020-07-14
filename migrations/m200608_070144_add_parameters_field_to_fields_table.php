<?php

use yii\db\Migration;

/**
 * Class m200608_070144_add_parameters_field_to_fields_table
 */
class m200608_070144_add_parameters_field_to_fields_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
                '{{%fields}}', 
                'parameters', 
                $this->text()
                    ->comment('Параметры')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%fields}}', 'parameters');  
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200608_070144_add_parameters_field_to_fields_table cannot be reverted.\n";

        return false;
    }
    */
}
