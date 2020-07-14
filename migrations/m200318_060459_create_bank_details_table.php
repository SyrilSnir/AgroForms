<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bank_details}}`.
 */
class m200318_060459_create_bank_details_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bank_details}}', [
            'id' => $this->primaryKey(),
            'rs_schet' => $this->string()->notNull()->comment('Расчетный счет'),
            'bank_info' => $this->string()->notNull()->comment('Информация о банке'),
            'ks_schet' => $this->string()->notNull()->comment('Корреспондентскй счет'),
            'bik' => $this->string()->notNull()->comment('Бик'),
        ]);
        $this->addForeignKey(
                    '{{%fk-companies-bank_details_id}}',
                    '{{%companies}}', 
                    'bank_details_id', 
                    '{{%bank_details}}', 
                    'id',
                    'CASCADE'
                );          
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%bank_details}}');
    }
}
