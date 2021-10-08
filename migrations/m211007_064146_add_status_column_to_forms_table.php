<?php

use app\models\ActiveRecord\Forms\Form;
use yii\db\Migration;

/**
 * Handles adding columns to table `{{%forms}}`.
 */
class m211007_064146_add_status_column_to_forms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%forms}}', 'status', $this->integer()->defaultValue(Form::STATUS_ACTIVE));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%forms}}', 'status');
    }
}
