<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%request}}`.
 */
class m210921_102121_add_type_id_column_to_requests_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%requests}}', 'type_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%requests}}', 'type_id');
    }
}
