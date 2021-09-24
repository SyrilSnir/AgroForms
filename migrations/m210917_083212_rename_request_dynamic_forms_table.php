<?php

use yii\db\Migration;

/**
 * Class m210917_083212_rename_request_dynamic_forms_table
 */
class m210917_083212_rename_request_dynamic_forms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameTable('{{%request_dynamic_forms}}', '{{%applications}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameTable('{{%applications}}','{{%request_dynamic_forms}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210917_083212_rename_request_dynamic_forms_table cannot be reverted.\n";

        return false;
    }
    */
}
