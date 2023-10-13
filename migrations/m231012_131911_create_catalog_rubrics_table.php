<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%catalog_rubrics}}`.
 */
class m231012_131911_create_catalog_rubrics_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%catalog_rubrics}}', [
            'catalog_id' => $this->integer()->notNull()->comment('Запись в каталоге'),
            'rubric_id' => $this->integer()->notNull()->comment('ID рубрики'),
            'PRIMARY KEY (catalog_id,rubric_id)'
        ]);
        // add foreign key for table `{{%company}}`
        $this->addForeignKey(
            '{{%fk-catalog_rubrics-catalog_id}}',
            '{{%catalog_rubrics}}',
            'catalog_id',
            '{{%catalog}}',
            'id',
            'CASCADE'
        );         
        $this->addForeignKey(
            '{{%fk-catalog_rubrics-rubric_id}}',
            '{{%catalog_rubrics}}',
            'rubric_id',
            '{{%rubricator}}',
            'id',
            'CASCADE'
        );            
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-catalog_rubrics-catalog_id}}', '{{%catalog_rubrics}}');
        $this->dropForeignKey('{{%fk-catalog_rubrics-rubric_id}}', '{{%catalog_rubrics}}');
        $this->dropTable('{{%catalog_rubrics}}');
    }
}
