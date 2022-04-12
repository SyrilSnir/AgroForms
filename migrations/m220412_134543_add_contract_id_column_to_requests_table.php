<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%requests}}`.
 */
class m220412_134543_add_contract_id_column_to_requests_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%requests}}', 'contract_id', $this->integer()->comment('Номер договора'));
        // creates index for column `contract_id`
        $this->createIndex(
            '{{%idx-requests-contract_id}}',
            '{{%requests}}',
            'contract_id'
        ); 
        
        // add foreign key for table `{{%requests}}`
        $this->addForeignKey(
            '{{%fk-requests-contract_id}}',
            '{{%requests}}',
            'contract_id',
            '{{%contracts}}',
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
            '{{%fk-requests-contract_id}}',
            '{{%requests}}'
        );

        // drops index for column `contract_id`
        $this->dropIndex(
            '{{%idx-requests-contract_id}}',
            '{{%requests}}'
        );         
        $this->dropColumn('{{%requests}}', 'contract_id');
    }
}
