<?php

use app\models\ActiveRecord\Common\Valute;
use yii\db\Migration;

/**
 * Handles adding columns to table `{{%form}}`.
 */
class m200810_085313_add_valute_id_column_to_form_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%forms}}', 'valute_id', $this->integer()->notNull()->defaultValue(Valute::RUB));
        
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%forms}}', 'valute_id');
    }
}
