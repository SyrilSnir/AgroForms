<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%field_labels}}`.
 */
class m231012_113900_create_field_labels_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%field_labels}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Название'),
            'name_eng' => $this->string()->comment('Название (ENG)'),
            'code' => $this->string()->notNull()->comment('Символьный код'),
        ]);
        // creates index for column `exhibition_id`
        $this->createIndex(
            '{{%idx-fields-label_id}}',
            '{{%fields}}',
            'label_id'
        ); 
        
        // add foreign key for table `{{%company}}`
        $this->addForeignKey(
            '{{%fk-fields-label_id}}',
            '{{%fields}}',
            'label_id',
            '{{%field_labels}}',
            'id',
            'CASCADE'
        );         
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%catalog}}`
        $this->dropForeignKey(
            '{{%fk-fields-label_id}}',
            '{{%fields}}'
        );
        // drops index for column `contract_id`
        $this->dropIndex(
            '{{%idx-fields-label_id}}',
            '{{%fields}}'
        );        // drops foreign key for table `{{%catalog}}`        
        $this->dropTable('{{%field_labels}}');
    }
}
