<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contract_media_fees}}`.
 */
class m240202_082830_create_contract_media_fees_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contract_media_fees}}', [
            'id' => $this->primaryKey(),
            'contract_id' => $this->integer()->notNull()->comment('Номер договора'),
            'media_fee_type' => $this->integer()->notNull()->comment('Тип взноса'),
            'count' => $this->integer()->notNull()->comment('Количество взносов'),
        ]);
        
        // creates index for column `contract_id`
        $this->createIndex(
            '{{%idx-contract_media_fees-contract_id}}',
            '{{%contract_media_fees}}',
            'contract_id'
        );

        // add foreign key for table `{%contract_media_fees}}`
        $this->addForeignKey(
            '{{%fk-contract_media_fees-contract_id}}',
            '{{%contract_media_fees}}',
            'contract_id',
            '{{%contract_media_fees}}',
            'id',
            'CASCADE'
        );

        // creates index for column `media_fee_type`
        $this->createIndex(
            '{{%idx-contract_media_fees-media_fee_type}}',
            '{{%contract_media_fees}}',
            'media_fee_type'
        );

        // add foreign key for table `{{%media_fee_types}}`
        $this->addForeignKey(
            '{{%fk-contract_media_fees-media_fee_type}}',
            '{{%contract_media_fees}}',
            'media_fee_type',
            '{{%media_fee_types}}',
            'id',
            'CASCADE'
        );        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{%contract_media_fees}}`
        $this->dropForeignKey(
            '{{%fk-contract_media_fees-contract_id}}',
            '{{%contract_media_fees}}'
        );

        // drops index for column `contract_id`
        $this->dropIndex(
            '{{%idx-contract_media_fees-contract_id}}',
            '{{%contract_media_fees}}'
        );

        // drops foreign key for table `{{%media_fee_types}}`
        $this->dropForeignKey(
            '{{%fk-contract_media_fees-media_fee_type}}',
            '{{%contract_media_fees}}'
        );

        // drops index for column `media_fee_type`
        $this->dropIndex(
            '{{%idx-contract_media_fees-media_fee_type}}',
            '{{%contract_media_fees}}'
        );
               
        $this->dropTable('{{%contract_media_fees}}');
    }
}
