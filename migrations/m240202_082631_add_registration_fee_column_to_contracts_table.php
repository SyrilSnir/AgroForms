<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%contracts}}`.
 */
class m240202_082631_add_registration_fee_column_to_contracts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%contracts}}', 'registration_fee', $this->integer()->defaultValue(0)->comment('Регистрационный взнос (количество)'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%contracts}}', 'registration_fee');
    }
}
