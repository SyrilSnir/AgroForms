<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%compaines}}`.
 */
class m200805_094923_add_proposal_signature_columns_to_contacts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%contacts}}', 'proposal_signature_post',  $this->string()->comment('Должность подписанта'));
        $this->addColumn('{{%contacts}}', 'proposal_signature_name',  $this->string()->comment('ФИО подписанта'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%contacts}}', 'proposal_signature_post');        
        $this->dropColumn('{{%contacts}}', 'proposal_signature_name');        
    }
}
