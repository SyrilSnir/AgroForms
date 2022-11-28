<?php

namespace app\controllers\api;

use app\controllers\JsonController;
use app\core\helpers\View\Form\FormElements\ElementAdditionEquipmentBlock;
use app\core\helpers\View\Form\FormHelper;
use app\core\providers\Data\FieldEnumProvider;
use app\core\providers\Data\Nomenclature\EquipmentGroupProvider;
use app\core\providers\Data\Nomenclature\EquipmentProvider;
use app\models\ActiveRecord\Forms\Field;
use app\models\ActiveRecord\Requests\BaseRequest;
use app\models\ActiveRecord\Requests\Request;
use Yii;
/**
 * Description of EquipmentController
 *
 * @author kotov
 */
class EquipmentController extends JsonController
{
    /**
     *
     * @var EquipmentGroupProvider
     */
    private $equipmentGroupProvider;
    
    /**
     *
     * @var EquipmentProvider
     */
    private $equipmentProvider;


    public function __construct(
            $id, 
            $module, 
            EquipmentGroupProvider $equipmentGroupProvider,
            EquipmentProvider $equipmentProvider,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->equipmentGroupProvider = $equipmentGroupProvider;
        $this->equipmentProvider = $equipmentProvider;
    }
   
        
    
    public function actionGetCategories():array
    {        
        return $this->equipmentGroupProvider->getList();
    }
    
    public function actionGetEquipments(int $categoryId,int $fieldId = null):array   
    {
        $request = null;
        $formChangeType = Yii::$app->session->get('FORM_CHANGE_TYPE');
        if ($formChangeType === Request::FORM_UPDATE) {
            $requestId = Yii::$app->session->get('REQUEST_ID');
            $request = Request::findOne($requestId);
        }
        $date = microtime(true);
        if ($request && (!in_array($request->status, [BaseRequest::STATUS_REJECTED, BaseRequest::STATUS_DRAFT]))) {
            $date = $request->activate_at ? $request->activate_at : $request->created_at;
        }
        
        $equipmentList = $this->equipmentProvider->getList($categoryId);
        if ($fieldId) {
            $langCode = Yii::$app->language;
            $field = Field::findOne($fieldId);
            $element = new ElementAdditionEquipmentBlock($field,  new FieldEnumProvider(),$langCode);
            FormHelper::appendPriceModificators($field, $element, $date);
            $equipmentList = array_map(function($el) use ($element) {
                $el['price'] = $element->modifyPrice($el['price']);
                return $el;
                
            },$equipmentList);
        }
        return $equipmentList;
    }
}
