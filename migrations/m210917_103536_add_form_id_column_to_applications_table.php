<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%applications}}`.
 */
class m210917_103536_add_form_id_column_to_applications_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%applications}}', 'form_id', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%applications}}', 'form_id');
    }
}
