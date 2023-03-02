<?php

namespace app\models\ActiveRecord\Nomenclature;

use app\core\behaviors\NestedSetsTreeBehavior;
use app\core\traits\ActiveRecord\MultilangTrait;
use app\models\ActiveRecord\Nomenclature\Query\RubricatorQuery;
use app\models\Forms\Nomenclature\RubricatorForm;
use creocoder\nestedsets\NestedSetsBehavior;
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
 * @property bool $deleted
 * @property Rubricator $parent
 * @property Rubricator[] $siblings все соседние элементы, включая самого себя
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
 * @method array tree(bool $showAll) Представление дерева в виде ассоциативного масссив
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
    
    public function __construct($config = [])
    {
        parent::__construct($config);
        if (!$this->isRussian()) {
            $this->labelAttribute = 'nameEng';
        }
    }


    public function edit(RubricatorForm $form): void
    {
        $this->name = $form->name;
        $this->nameEng = $form->nameEng;
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
    
    public function getSiblings($includeMyself = true): array
    {
        if ($this->isRoot()) {
            return [];
        }
        $parent = $this->getParent();
        $children = $parent->directChildren(); 
        if (!$includeMyself) {
            $children->andFilterWhere(['!=','id',$this->id]);
        }
        return $children->orderBy('lft')->all();
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
    
    /**
     * 
     * @return self|null
     */
    public function getParent() 
    {
        if (!$this->isRoot()) {
            return $this->parents(1)->one();
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
    
    public function sortedTree($showAll = false) :array
    {
        $arr =  $this->tree($showAll);
        
        $this->orderedSort($arr);
        return $arr;
    }
    
    private function orderedSort(array &$arr) 
    {
        usort($arr, function($a1, $a2) {
            if($a1['order'] > $a2['order']) return 1;
            if($a1['order'] < $a2['order']) return -1;
            return 0;
        });
        foreach ($arr as &$element) {
            if(!empty($element['children'])) {
                $this->orderedSort($element['children']);
            }        
        }
    }
    
    public function sortedList(): array 
    {
        $tree = $this->tree();
        $elements = [];
        $this->getSortedElements($tree, $elements);
        return $elements;
    }
    
    private function getSortedElements($arr, &$elements)
    {
        usort($arr, function($a1, $a2) {
            if($a1['order'] > $a2['order']) return 1;
            if($a1['order'] < $a2['order']) return -1;
            return 0;
        });
        foreach ($arr as $element) {
            $elements[$element['id']] = str_repeat('► ', $element['depth']) . $element['name'];
            if(!empty($element['children'])) {
                $this->getSortedElements($element['children'],$elements);
            }        
        }        
    }
    
    public function directChildren() 
    {
        if ($this->isLeaf()) {
            return null;
        }
        return $this->children(1)->orderBy('order');
    }
    
    public function reindexDirectChildren()
    {
        $children = $this->directChildren()->all();
        if (empty($children)) {
            return;
        }
        $index = 1;
        array_walk($children, function(Rubricator $item) use (&$index) {
            if ($item->order != $index) {
                $item->order = $index;
                $item->save();                        
            }
            $index++;
        });
        return $children;
    }
}
