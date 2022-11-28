<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%companies}}`.
 */
class m221125_085621_add_logo_column_to_companies_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%companies}}', 'logo', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%companies}}', 'logo');
    }
}
