<?php

use app\models\ActiveRecord\Requests\Request;
use yii\db\Migration;

/**
 * Handles adding columns to table `{{%requests}}`.
 */
class m220419_101655_add_company_id_column_to_requests_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%requests}}', 'company_id', $this->integer());
        // creates index for column `contract_id`
        $this->createIndex(
            '{{%idx-requests-company_id}}',
            '{{%requests}}',
            'company_id'
        ); 
        
        // add foreign key for table `{{%requests}}`
        $this->addForeignKey(
            '{{%fk-requests-company_id}}',
            '{{%requests}}',
            'company_id',
            '{{%companies}}',
            'id',
            'CASCADE'
        );
        $this->setDefaultCompanies();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%company}}`
        $this->dropForeignKey(
            '{{%fk-requests-company_id}}',
            '{{%contracts}}'
        );

        // drops index for column `company_id`
        $this->dropIndex(
            '{{%idx-requests-company_id}}',
            '{{%requests}}'
        );         
        $this->dropColumn('{{%requests}}', 'company_id');
    }
    
    private function setDefaultCompanies()
    {
        $requests = Request::find()->all();
        foreach ($requests as $request) {
        /** @var Request $request */
            if ($request->contract) {
                $request->company_id = $request->contract->company_id;
                $request->save();
            }
        }
    }
}
