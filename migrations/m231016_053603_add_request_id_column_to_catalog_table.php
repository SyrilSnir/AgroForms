<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%catalog}}`.
 */
class m231016_053603_add_request_id_column_to_catalog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%catalog}}', 'request_id', $this->integer()->notNull()->comment('Номер заявки'));
        // creates index for column `request_id`
        $this->createIndex(
            '{{%idx-catalog-request_id}}',
            '{{%catalog}}',
            'request_id'
        ); 
        
        // add foreign key for table `{{%company}}`
        $this->addForeignKey(
            '{{%fk-catalog-request_id}}',
            '{{%catalog}}',
            'request_id',
            '{{%requests}}',
            'id',
            'CASCADE'
        );         
    }
    
    

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%catalog}}`
        $this->dropForeignKey(
            '{{%fk-catalog-request_id}}',
            '{{%catalog}}'
        );

        // drops index for column `contract_id`
        $this->dropIndex(
            '{{%idx-catalog-request_id}}',
            '{{%catalog}}'
        );         
        $this->dropColumn('{{%catalog}}', 'request_id');
    }
}
