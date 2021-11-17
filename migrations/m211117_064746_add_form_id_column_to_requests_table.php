<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%requests}}`.
 */
class m211117_064746_add_form_id_column_to_requests_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%requests}}', 'form_id', $this->integer()->notNull()->comment('Id формы'));
       $this->createIndex(
            'idx-requests-form_id',
            '{{%requests}}',
            'form_id'
        );  
/*        $this->addForeignKey(
                'fk-requests-form_id', 
                '{{%requests}}', 
                'form_id', 
                '{{%forms}}', 
                'id',
                'CASCADE'
                );         */
    }    

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-requests-form_id', '{{%requests}}');        
        $this->dropColumn('{{%requests}}', 'form_id');
    }
}
