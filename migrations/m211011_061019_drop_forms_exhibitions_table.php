<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%forms_exhibitions}}`.
 */
class m211011_061019_drop_forms_exhibitions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // drops foreign key for table `{{%forms}}`
        $this->dropForeignKey(
            '{{%fk-forms_exhibitions-forms_id}}',
            '{{%forms_exhibitions}}'
        );

        // drops index for column `forms_id`
        $this->dropIndex(
            '{{%idx-forms_exhibitions-forms_id}}',
            '{{%forms_exhibitions}}'
        );

        // drops foreign key for table `{{%exhibitions}}`
        $this->dropForeignKey(
            '{{%fk-forms_exhibitions-exhibitions_id}}',
            '{{%forms_exhibitions}}'
        );

        // drops index for column `exhibitions_id`
        $this->dropIndex(
            '{{%idx-forms_exhibitions-exhibitions_id}}',
            '{{%forms_exhibitions}}'
        );

        $this->dropTable('{{%forms_exhibitions}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('{{%forms_exhibitions}}', [
            'forms_id' => $this->integer(),
            'exhibitions_id' => $this->integer(),
            'PRIMARY KEY(forms_id, exhibitions_id)',
        ]);

        // creates index for column `forms_id`
        $this->createIndex(
            '{{%idx-forms_exhibitions-forms_id}}',
            '{{%forms_exhibitions}}',
            'forms_id'
        );

        // add foreign key for table `{{%forms}}`
        $this->addForeignKey(
            '{{%fk-forms_exhibitions-forms_id}}',
            '{{%forms_exhibitions}}',
            'forms_id',
            '{{%forms}}',
            'id',
            'CASCADE'
        );

        // creates index for column `exhibitions_id`
        $this->createIndex(
            '{{%idx-forms_exhibitions-exhibitions_id}}',
            '{{%forms_exhibitions}}',
            'exhibitions_id'
        );

        // add foreign key for table `{{%exhibitions}}`
        $this->addForeignKey(
            '{{%fk-forms_exhibitions-exhibitions_id}}',
            '{{%forms_exhibitions}}',
            'exhibitions_id',
            '{{%exhibitions}}',
            'id',
            'CASCADE'
        );
    }
}
