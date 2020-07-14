<?php

use app\core\traits\Db\QueryTrait;
use app\models\ActiveRecord\Requests\Request;
use yii\db\Migration;

/**
 * Class m200626_130734_change_form_type_column_in_requests_table
 */
class m200626_130734_change_form_type_column_in_requests_table extends Migration
{
    use QueryTrait;
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {                
        /** @var Request $request */
        $prefix = Yii::$app->db->tablePrefix;
        $sql = 'DELETE FROM '.$prefix.'request_stands;'  .
               'DELETE FROM '.$prefix.'request_dynamic_forms;'  .
               'DELETE FROM '.$prefix.'requests;';  
       $this->query($sql);
       
       $this->dropForeignKey('fk-requests-form_type_id', 'requests');
        $this->dropIndex(
            'idx-requests-form_type_id',
            '{{%requests}}'
            ); 
        $this->renameColumn('{{%requests}}', 'form_type_id', 'form_id');
        $this->createIndex(
            'idx-requests-form_id',
            '{{%requests}}',
            'form_id'
            );
        $this->addForeignKey(
            '{{%fk-requests-form_id}}', 
            '{{%requests}}', 
            'form_id', 
            '{{%forms}}', 
            'id',
            'CASCADE');         
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-requests-form_id', 'requests');        
        $this->dropIndex(
            'idx-requests-form_id',
            '{{%requests}}'
            );  
        $this->renameColumn('{{%requests}}', 'form_id', 'form_type_id');        
        $this->createIndex(
            'idx-requests-form_type_id',
            '{{%requests}}',
            'form_type_id'
            );
        $this->addForeignKey(
            '{{%fk-requests-form_type_id}}', 
            '{{%requests}}', 
            'form_type_id', 
            '{{%form_types}}', 
            'id',
            'CASCADE');  
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200626_130734_change_form_type_column_in_requests_table cannot be reverted.\n";

        return false;
    }
    */
}
