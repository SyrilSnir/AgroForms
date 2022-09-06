<?php

use yii\db\Migration;

/**
 * Class m220906_092159_set_company_id_field_nullable_in_documents_table
 */
class m220906_092159_set_company_id_field_nullable_in_documents_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey(
            '{{%fk-documents-company_id}}',
            '{{%documents}}'
        );  
        
        $this->alterColumn('{{%documents}}', 'company_id', $this->integer()->unsigned()->null());               
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220906_092159_set_company_id_field_nullable_in_documents_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220906_092159_set_company_id_field_nullable_in_documents_table cannot be reverted.\n";

        return false;
    }
    */
}
