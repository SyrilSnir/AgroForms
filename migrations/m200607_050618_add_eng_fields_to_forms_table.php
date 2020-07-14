<?php

use yii\db\Migration;

/**
 * Class m200607_050618_add_eng_fields_to_forms_table
 */
class m200607_050618_add_eng_fields_to_forms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
                '{{%forms}}', 
                'name_eng', 
                $this->string()
                    ->comment('Наименование для английской версии')
        );
        $this->addColumn(
                '{{%forms}}', 
                'title_eng', 
                $this->string()
                    ->comment('Заголовок для английской версии')
        );
        $this->addColumn(
                '{{%forms}}', 
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
         $this->dropColumn('{{%forms}}', 'name_eng');        
         $this->dropColumn('{{%forms}}', 'title_eng');        
         $this->dropColumn('{{%forms}}', 'description_eng');        
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200607_050618_add_eng_fields_to_forms_table cannot be reverted.\n";

        return false;
    }
    */
}
