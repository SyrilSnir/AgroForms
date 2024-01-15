<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%equipment_prices}}`.
 */
class m231229_094607_create_equipment_prices_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%equipment_prices}}', [
            'exhibition_id' => $this->integer(),          
            'equipment_id' => $this->integer(),
            'price' => $this->integer()->notNull()->comment('Стоимость'),
            'PRIMARY KEY(equipment_id, exhibition_id)',                
        ]);
        // creates index for column `equipment_id`
        $this->createIndex(
            '{{%idx-equipment_prices-equipment_id}}',
            '{{%equipment_prices}}',
            'equipment_id'
        );

        // add foreign key for table `{%additional_equipment}}`
        $this->addForeignKey(
            '{{%fk-equipment_prices-equipment_id}}',
            '{{%equipment_prices}}',
            'equipment_id',
            '{{%additional_equipment}}',
            'id',
            'CASCADE'
        );

        // creates index for column `exhibition_id`
        $this->createIndex(
            '{{%idx-equipment_prices-exhibition_id}}',
            '{{%equipment_prices}}',
            'exhibition_id'
        );

        // add foreign key for table `{{%exhibitions}}`
        $this->addForeignKey(
            '{{%fk-equipment_prices-exhibition_id}}',
            '{{%equipment_prices}}',
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
        // drops foreign key for table `{%additional_equipment}}`
        $this->dropForeignKey(
            '{{%fk-equipment_prices-equipment_id}}',
            '{{%equipment_prices}}'
        );

        // drops index for column `equipment_id`
        $this->dropIndex(
            '{{%idx-equipment_prices-equipment_id}}',
            '{{%equipment_prices}}'
        );

        // drops foreign key for table `{{%exhibitions}}`
        $this->dropForeignKey(
            '{{%fk-equipment_prices-exhibition_id}}',
            '{{%equipment_prices}}'
        );

        // drops index for column `exhibition_id`
        $this->dropIndex(
            '{{%idx-equipment_prices-exhibition_id}}',
            '{{%equipment_prices}}'
        );
       
        $this->dropTable('{{%equipment_prices}}');
    }
}
