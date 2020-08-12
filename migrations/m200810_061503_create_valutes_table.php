<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%valutes}}`.
 */
class m200810_061503_create_valutes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%valutes}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Наименование'),
            'int_name' => $this->string()->comment('Международное название'),
            'char_code' => $this->string()->comment('Трехбуквенное обозначение'),
            'symbol' => $this->string()->comment('Символьный код')
            
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%valutes}}');
    }
}
