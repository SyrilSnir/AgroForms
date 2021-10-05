<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%exhibitions}}`.
 */
class m211005_081521_add_columns_to_exhibitions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%exhibitions}}', 'disassembling_start', $this->integer());
        $this->addColumn('{{%exhibitions}}', 'disassembling_end', $this->integer());
        $this->addColumn('{{%exhibitions}}', 'assembling_start', $this->integer());
        $this->addColumn('{{%exhibitions}}', 'assembling_end', $this->integer());        
        $this->addColumn('{{%exhibitions}}', 'company_id', $this->integer()->notNull()->defaultValue(1)->comment('Компания Организатор'));
        $this->addColumn('{{%exhibitions}}', 'address', $this->string()->comment('Место проведения'));
        $this->createIndex(
            'idx-exhibitions-company_id',
            '{{%exhibitions}}',
            'company_id'
        );  
        $this->addForeignKey(
                'fk-exhibitions-company_id', 
                '{{%exhibitions}}', 
                'company_id', 
                '{{%companies}}', 
                'id',
                'CASCADE'
                );               
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-exhibitions-company_id', '{{%exhibitions}}');
        $this->dropIndex('idx-exhibitions-company_id', '{{%exhibitions}}');
        $this->dropColumn('{{%exhibitions}}', 'assembling_start');
        $this->dropColumn('{{%exhibitions}}', 'assembling_end');        
        $this->dropColumn('{{%exhibitions}}', 'disassembling_start');
        $this->dropColumn('{{%exhibitions}}', 'disassembling_end');
        $this->dropColumn('{{%exhibitions}}', 'address');
        $this->dropColumn('{{%exhibitions}}', 'company_id');
    }
}
