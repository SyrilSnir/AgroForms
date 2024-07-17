<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%rubricator}}`.
 */
class m240717_064034_add_is_agrocomponent_column_to_rubricator_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%rubricator}}', 'is_agrocomponent', $this->boolean()->defaultValue(false)->comment('Является агрокомпонентом'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%rubricator}}', 'is_agrocomponent');
    }
}
