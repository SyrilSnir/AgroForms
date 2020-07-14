<?php

namespace app\core\services\operations;

use app\core\repositories\manage\ConfigurationRepository;
use app\models\ActiveRecord\Configuration;
use app\models\Forms\Manage\Configuration\ConfigurationFormInterface;

/**
 * Description of SettingsService
 *
 * @author kotov
 */
class SettingsService
{
    /**
     *
     * @var ConfigurationRepository
     */
     protected $configuration;   
    
     public function __construct(ConfigurationRepository $configuration)
     {
         $this->configuration = $configuration;
     }

     
    public function saveConfiguration(ConfigurationFormInterface $form, $section) 
    {
      // $settingsList = ConfigurationHelper::getConfig(Configuration::STAND_SETTINGS_SECTION);
      /** @var Configuration $model */
       $fields = array_keys($form->fields());
       foreach ($fields as $field) {
           $value = $form->$field;
           $model = $this->configuration->findByAttribute($section, $field);
           if (!$model) {
               $model = Configuration::create($section, $field, $value);
           } else {
               $model->edit($section, $field, $value);
           }
           $this->configuration->save($model);
       }
    }
    
}
