<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%fields}}`.
 */
class m231012_110136_add_label_id_column_to_fields_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%fields}}', 'label_id', $this->integer()->comment('Метка'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%fields}}', 'label_id');
    }
}
