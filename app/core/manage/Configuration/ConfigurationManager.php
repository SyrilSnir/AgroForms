<?php

namespace app\core\manage\Configuration;

use app\core\helpers\Data\ConfigurationHelper;
use app\core\traits\SingltoneTrait;
use app\models\ActiveRecord\Configuration;
use app\models\Configuration\SmtpParameters;
use app\models\Configuration\StandConfiguration;
use yii\base\Model;

/**
 * Description of ConfigurationManager
 *
 * @author kotov
 */
class ConfigurationManager
{
    /**
     *
     * @var StandConfiguration
     */
    private $standConfiguration;
    
    /**
     *
     * @var SmtpParameters
     */
    private $smtpParameters;
    
    use SingltoneTrait;
    
    /**
     * 
     * @return StandConfiguration
     */
    public function getStandConfiguration() : StandConfiguration
    {   
        if ($this->standConfiguration) {
            return $this->standConfiguration;
        }
        $this->standConfiguration = new StandConfiguration();
        $this->setConfigurationAttributes($this->standConfiguration, Configuration::STAND_SETTINGS_SECTION);
        return $this->standConfiguration;
        
    }
    
    /**
     * 
     * @return SmtpParameters
     */
    public function getSmtpParameters() : SmtpParameters
    {
        if ($this->smtpParameters) {
            return $this->smtpParameters;
        }
        $this->smtpParameters = new Mail();
        $this->setConfigurationAttributes($this->smtpParameters, Configuration::SMTP_SETTINGS_SECTION);
        return $this->smtpParameters;
    }

        /**
     * 
     * @param Model $configuration
     * @param string $section
     * @return array
     */
    private function setConfigurationAttributes(Model $configuration, string $section)
    {
        $attrs = ConfigurationHelper::getConfig($section);
       $configuration->setAttributes($attrs, false);
    }
}
