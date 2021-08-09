<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user_types}}`.
 */
class m210809_074243_add_name_eng_column_to_user_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user_types}}', 'name_eng', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user_types}}', 'name_eng');
    }
}
