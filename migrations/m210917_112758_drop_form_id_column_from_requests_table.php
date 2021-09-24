<?php

use app\models\ActiveRecord\Requests\Request;
use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%requests}}`.
 */
class m210917_112758_drop_form_id_column_from_requests_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->truncateTable('{{%applications}}');
        $this->truncateTable('{{%request_stands}}');
        Request::deleteAll();
        $this->dropForeignKey('fk-requests-form_id', '{{%requests}}');
        $this->dropColumn('{{%requests}}', 'form_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%requests}}', 'form_id', $this->integer());
    }
}
