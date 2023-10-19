<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%catalog}}`.
 */
class m231019_054609_drop_country_column_from_catalog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%catalog}}', 'country');
        $this->dropColumn('{{%catalog}}', 'country_eng');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
