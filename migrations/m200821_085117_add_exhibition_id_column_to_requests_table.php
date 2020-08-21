<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%requests}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%exhibitions}}`
 */
class m200821_085117_add_exhibition_id_column_to_requests_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%requests}}', 'exhibition_id', $this->integer());

        // creates index for column `exhibition_id`
        $this->createIndex(
            '{{%idx-requests-exhibition_id}}',
            '{{%requests}}',
            'exhibition_id'
        );

        // add foreign key for table `{{%exhibitions}}`
        $this->addForeignKey(
            '{{%fk-requests-exhibition_id}}',
            '{{%requests}}',
            'exhibition_id',
            '{{%exhibitions}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%exhibitions}}`
        $this->dropForeignKey(
            '{{%fk-requests-exhibition_id}}',
            '{{%requests}}'
        );

        // drops index for column `exhibition_id`
        $this->dropIndex(
            '{{%idx-requests-exhibition_id}}',
            '{{%requests}}'
        );

        $this->dropColumn('{{%requests}}', 'exhibition_id');
    }
}
