<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rubricator}}`.
 */
class m221228_064430_create_rubricator_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%rubricator}}', [
            'id' => $this->primaryKey(),
            'order' => $this->integer()->notNull()->comment('Порядковый номер'),
            'name' => $this->string()->notNull(),
            'nameEng' => $this->string(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%rubricator}}');
    }
}
