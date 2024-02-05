<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%media_fee_types}}`.
 */
class m240202_082708_create_media_fee_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%media_fee_types}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Название взноса'),
            'name_eng' => $this->string()->notNull()->comment('Название взноса (ENG)'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%media_fee_types}}');
    }
}
