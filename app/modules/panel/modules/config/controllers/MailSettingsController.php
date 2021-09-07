<?php

namespace app\modules\panel\modules\config\controllers;

use app\core\helpers\Data\ConfigurationHelper;
use app\core\services\operations\SettingsService;
use app\models\ActiveRecord\Configuration;
use app\models\Forms\Manage\Configuration\MailConfigurationForm;
use app\modules\panel\controllers\AccessRule\BaseAdminController;
use Yii;

/**
 * Description of MailSettingsController
 *
 * @author kotov
 */
class MailSettingsController extends BaseAdminController
{
    /**
     *
     * @var SettingsService
     */
    protected $settingsService;

     public function __construct(
            $id, 
            $module, 
            SettingsService $settingsService,
            $config = array()
            )
    {
        parent::__construct($id, $module, $config);
        $this->settingsService = $settingsService;
    }
    
    public function actionIndex()
    {
        $form = new MailConfigurationForm();
        $config = ConfigurationHelper::getConfig(Configuration::SMTP_SETTINGS_SECTION);
        if ($config) {
            $form->setAttributes($config);
        }        
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->settingsService->saveConfiguration($form, Configuration::SMTP_SETTINGS_SECTION);
            Yii::$app->session->setFlash('configurationSaved', 'Конфигурация успешно сохранена');
        }
        return $this->render('settings',[
            'model' => $form
        ]);
    }
    
}
