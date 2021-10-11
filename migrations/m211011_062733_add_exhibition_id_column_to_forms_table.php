<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%forms}}`.
 */
class m211011_062733_add_exhibition_id_column_to_forms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
    //    $this->addColumn('{{%forms}}', 'exhibition_id', $this->integer()->comment('Id выставки'));
        // creates index for column `exhibitions_id`
        $this->createIndex(
            '{{idx-forms-exhibitions_id}}',
            '{{%forms}}',
            'exhibition_id'
        );  
        // add foreign key for table `{{%exhibitions}}`
        $this->addForeignKey(
            '{{fk-forms-exhibition_id}}',
            '{{%forms}}',
            'exhibition_id',
            '{{%exhibitions}}',
            'id',
            'CASCADE'
        );        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%exhibitions}}`
        $this->dropForeignKey(
            '{{fk-forms-exhibition_id}}',
            '{{%forms}}'
        );

        // drops index for column `exhibition_id`
        $this->dropIndex(
            '{{%idx-forms-exhibition_id}}',
            '{{%forms}}'
        );        
        $this->dropColumn('{{%forms}}', 'exhibition_id');
    }
}
