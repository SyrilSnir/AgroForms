<?php

namespace app\models\ActiveRecord\Nomenclature;

use app\core\traits\ActiveRecord\MultilangTrait;
use app\models\ActiveRecord\Nomenclature\Query\RubricatorQuery;
use app\models\Forms\Nomenclature\RubricatorForm;
use creocoder\nestedsets\NestedSetsBehavior;
use wokster\treebehavior\NestedSetsTreeBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "rubricator".
 *
 * @property int $id
 * @property string $name
 * @property string $nameEng
 * @property int $lft
 * @property int $rgt
 * @property int $order
 * @property int $depth
 * @property Rubricator $parent
 * 
 * @method boolean makeRoot(boolean $runValidation = true,array $attributes = null) Создать корневой элемент
 * @method boolean prependTo(ActiveRecord $node,boolean $runValidation = true,array $attributes = null) Добавить, как первый дочерний элемент
 * @method boolean appendTo(ActiveRecord $node,boolean $runValidation = true,array $attributes = null) Добавить, как последний дочерний элемент
 * @method boolean insertBefore(ActiveRecord $node,boolean $runValidation = true,array $attributes = null) Добавить как предыдущего соседа
 * @method boolean insertAfter(ActiveRecord $node,boolean $runValidation = true,array $attributes = null) Добавить как следующего соседа
 * @method boolean|int deleteWithChildren() Удалить вместе с дочерними
 * @method ActiveQuery parents($depth = null) Вернуть предков
 * @method ActiveQuery children($depth = null) Вернуть потомков
 * @method ActiveQuery leaves() Вернуть узловые элементы
 * @method ActiveQuery prev() Вернуть предыдущего соседа
 * @method ActiveQuery next() Вернуть следующего соседа
 * @method boolean isRoot() Проверить, является ли корнем
 * @method boolean isChildOf(ActiveRecord $node) Является ли дочерним для заданного узла
 * @method boolean isLeaf() Проверить, является ли узлом
 * @method void beforeInsert() Вызывается перед вставкой элемента
 * @method void beforeUpdate() Вызывается перед обновлением элемента
 * @method void afterInsert() Вызывается после вставки элемента
 * @method void afterUpdate() Вызывается после обновлением элемента
 * 
 * @method array tree() Представление дерева в виде ассоциативного масссив
 */
class Rubricator extends ActiveRecord
{
    use MultilangTrait;
    /**
     * Создать корневую ноду
     * @param string $name
     * @param string $nameEng
     */
    public static function createRootNode(string $name,string $nameEng = ''): self
    {
        $model = new self();
        $model->name = $name;
        $model->nameEng = $nameEng;
        $model->order = 1;
        $model->makeRoot();
        return $model;
                
    }
    
    /**
     * Создать обычный раздел
     * @param string $name
     * @param string $nameEng
     */
    public static function createAnyNode(string $name,string $nameEng = '', int $order = 1): self
    {
        $model = new self();
        $model->name = $name;
        $model->nameEng = $nameEng;
        $model->order = $order;        
        return $model;
                
    }  
    
    public function edit(RubricatorForm $form): void
    {
        $this->name = $form->name;
        $this->nameEng = $form->nameEng;
        $this->order = $form->order;
    }


    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::class,
            ],
            'htmlTree' => [
                'class' => NestedSetsTreeBehavior::class
            ]
        ];
    }  
    
    /**
     * 
     */
    public static function find(): RubricatorQuery
    {
        return new RubricatorQuery(static::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rubricator';
    }
    
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    } 
    
    public function getParent() 
    {
        if (!$this->isRoot()) {
            return $this->parents()->andWhere(['depth' => $this->depth - 1])->one();
        } else {
            return null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'order'], 'required'],
            [['lft', 'rgt', 'depth','order'], 'integer'],
            [['name', 'nameEng'], 'string', 'max' => 255],
        ];
    }
}
