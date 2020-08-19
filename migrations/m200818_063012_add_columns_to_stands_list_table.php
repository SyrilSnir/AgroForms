<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%stands_list}}`.
 */
class m200818_063012_add_columns_to_stands_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%stands_list}}', 'name_eng', $this->string());
        $this->addColumn('{{%stands_list}}', 'description_eng', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%stands_list}}', 'name_eng');
        $this->dropColumn('{{%stands_list}}', 'description_eng');
    }
}
