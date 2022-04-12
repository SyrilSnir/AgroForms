<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%contracts}}`.
 */
class m220412_074836_add_exhitbition_id_column_to_contracts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%contracts}}', 'exhibition_id', $this->integer()->comment('Выставка'));
        // creates index for column `exhibition_id`
        $this->createIndex(
            '{{%idx-contracts-exhibition_id}}',
            '{{%contracts}}',
            'exhibition_id'
        ); 
        
        // add foreign key for table `{{%company}}`
        $this->addForeignKey(
            '{{%fk-contracts-exhibition_id}}',
            '{{%contracts}}',
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
        // drops foreign key for table `{{%contracts}}`
        $this->dropForeignKey(
            '{{%fk-contracts-exhibition_id}}',
            '{{%contracts}}'
        );

        // drops index for column `exhibition_id`
        $this->dropIndex(
            '{{%idx-contracts-exhibition_id}}',
            '{{%contracts}}'
        );          
        $this->dropColumn('{{%contracts}}', 'exhibition_id');
    }
}
