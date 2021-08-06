<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%regions}}`.
 */
class m210806_090727_add_name_eng_column_to_regions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%regions}}', 'name_eng', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%regions}}', 'name_eng');
    }
}
