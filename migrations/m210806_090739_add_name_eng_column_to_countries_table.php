<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%countries}}`.
 */
class m210806_090739_add_name_eng_column_to_countries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%countries}}', 'name_eng', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%countries}}', 'name_eng');
    }
}
