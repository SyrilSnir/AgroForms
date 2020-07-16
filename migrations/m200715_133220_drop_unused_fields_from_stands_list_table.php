<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%unused_fields_from_stands_list}}`.
 */
class m200715_133220_drop_unused_fields_from_stands_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->dropColumn('{{%stands_list}}', 'free_digits');
         $this->dropColumn('{{%stands_list}}', 'digit_price');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%stands_list}}', 'free_digits', $this->integer()->comment('Количество бесплатных знаков'));
        $this->addColumn('{{%stands_list}}', 'digit_price', $this->integer()->notNull()->comment('Стоимость символа'));
    }
}
