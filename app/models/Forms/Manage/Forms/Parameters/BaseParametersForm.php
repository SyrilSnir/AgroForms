<?php

namespace app\models\Forms\Manage\Forms\Parameters;

use app\core\traits\Lists\GetCategoriesListTrait;
use app\models\ActiveRecord\Forms\Field;
use app\models\ActiveRecord\Requests\AttachedFiles;
use yii\base\Model;
use function GuzzleHttp\json_decode;

/**
 * Description of BaseParametersForm
 *
 * @author kotov
 */
abstract class BaseParametersForm extends Model
{
    
    const STANDART_GROUP_TYPE = 0;
    const CONDITIONALLY_HIDDEN_GROP_TYPE = 1;
    const HIDDEN_GROUP_TYPE = 2;
    
    /**
     * 
     * @var Field|null
     */
    protected $field;  



    use GetCategoriesListTrait;    
    /**
     * 
     * @var array
     */
    protected $paramsArray = [];
    
    public function __construct(Field $field = null, $config = [])
    {
        if ($field) {
            $this->paramsArray = json_decode($field->parameters, true);
            $this->field = $field;
        }
        parent::__construct($config);
    }    

    public function groupTypesList(): array
    {
        return [
            self::STANDART_GROUP_TYPE => t('Standard group type'),
            self::CONDITIONALLY_HIDDEN_GROP_TYPE => t('Group with conditional display'),
            self::HIDDEN_GROUP_TYPE => t('Group for hidden elements'),
        ];
    }
    
    public function attachmentTypesList(): array 
    {
        return [
            AttachedFiles::STANDART_TYPE =>  t('Any file types'),
            AttachedFiles::SITE_LOGO_TYPE => t('Logo for the website'),
            AttachedFiles::CATALOG_LOGO_TYPE => t('Logo to catalog') 
        ];
    }


    public function getUnitPrice() {
        if (property_exists($this, 'unitPrice')) {
            return $this->unitPrice;
        }
        return 0;
    }
    
    abstract function getViewParameters(): array;
}
