<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%cities}}`.
 */
class m210806_090651_add_name_eng_column_to_cities_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%cities}}', 'name_eng', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%cities}}', 'name_eng');
    }
}
