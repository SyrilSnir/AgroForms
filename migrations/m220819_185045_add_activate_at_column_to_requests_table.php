<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%requests}}`.
 */
class m220819_185045_add_activate_at_column_to_requests_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%requests}}', 'activate_at', $this->integer()->unsigned()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%requests}}', 'activate_at');
    }
}
