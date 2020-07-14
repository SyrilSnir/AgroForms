<?php

use yii\db\Migration;

/**
 * Class m200602_231058_add_eng_fields_to_nomenclature_tables
 */
class m200602_231058_add_eng_fields_to_nomenclature_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
                '{{%additional_equipment}}', 
                'name_eng', 
                $this->string()
                    ->comment('Наименование для английской версии')
        );
        $this->addColumn(
                '{{%additional_equipment}}', 
                'description_eng', 
                $this->text()
                    ->comment('Наименование для английской версии')
        );   
        
        $this->addColumn(
                '{{%equipment_groups}}', 
                'name_eng', 
                $this->string()
                    ->comment('Наименование для английской версии')
        );
        $this->addColumn(
                '{{%equipment_groups}}', 
                'description_eng', 
                $this->text()
                    ->comment('Наименование для английской версии')
        );   
        
        $this->addColumn(
                '{{%units}}', 
                'name_eng', 
                $this->string()
                    ->comment('Наименование для английской версии')
        );
        $this->addColumn(
                '{{%units}}', 
                'short_name_eng', 
                $this->text()
                    ->comment('Краткое наименовние для английской версии')
        );         
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         $this->dropColumn('{{%additional_equipment}}', 'name_eng');
         $this->dropColumn('{{%additional_equipment}}', 'description_eng');
         
         $this->dropColumn('{{%equipment_groups}}', 'name_eng');
         $this->dropColumn('{{%equipment_groups}}', 'description_eng');         
         
         $this->dropColumn('{{%units}}', 'name_eng');
         $this->dropColumn('{{%units}}', 'short_name_eng');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200602_231058_add_eng_fields_to_nomenclature_tables cannot be reverted.\n";

        return false;
    }
    */
}
