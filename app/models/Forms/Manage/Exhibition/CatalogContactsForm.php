<?php

namespace app\models\Forms\Manage\Exhibition;

/**
 * Description of CatalogContactsForm
 *
 * @author kotov
 */
class CatalogContactsForm extends \yii\base\Model
{
    public $site;
    public $email;
    public $phone;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['site', 'email','phone'], 'string'],
            [['site'], function($attr,$params) {
                if (empty($this->site) && empty($this->email) && empty($this->phone)) {
                    $this->addError('site','Поля не заполнены');
                }
            }, 'skipOnEmpty' => false],
        ];
    }     
}
