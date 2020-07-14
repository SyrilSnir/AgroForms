<?php

use yii\db\Migration;

/**
 * Class m200608_094332_add_eng_fields_columns_from_fields_table
 */
class m200608_094332_add_eng_fields_columns_from_fields_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
                '{{%fields}}', 
                'name_eng', 
                $this->string()
                    ->comment('Наименование для английской версии')
        );
        
        $this->addColumn(
                '{{%fields}}', 
                'description_eng', 
                $this->string()
                    ->comment('Описание для английской версии')
        ); 
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         $this->dropColumn('{{%fields}}', 'name_eng');               
         $this->dropColumn('{{%fields}}', 'description_eng');  
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200608_094332_add_eng_fields_columns_from_fields_table cannot be reverted.\n";

        return false;
    }
    */
}
