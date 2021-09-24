<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%polls}}`.
 */
class m210921_104608_create_polls_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%polls}}', [
            'id' => $this->primaryKey(),
            'request_id' => $this->integer()->notNull()->comment('Id заявки'),
            'form_id' => $this->integer()->notNull()->comment('Id формы'),
            'fields' => $this->text()->comment('Данные формы')            
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%polls}}');
    }
}
