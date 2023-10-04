<?php

namespace app\models\Forms\Requests;

use app\models\Forms\Manage\Forms\Parameters\BaseParametersForm;
use yii\web\UploadedFile;

/**
 * Description of AttachedFilesForm
 *
 * @author kotov
 */
class AttachedFilesForm extends BaseParametersForm
{
    public $files = [];
    
    private $_fileFields;
    
    public function rules(): array
    {
        return [
            [['fileFields'], 'required'],
            [['fileFields'],'each','rule'  => ['integer']],  
            [['files'],'each','rule'  => ['file']],             
        ];
    }        
    /**
     * 
     * @param string|array $data
     * @return type
     */
    public function setFileFields($data) 
    {
        if (is_array($data)) {
            $this->fileFields = $data;
            return $data;
        }
        if ($data) {
            $this->_fileFields = explode(',', $data);
        } else {
            $this->_fileFields = [];
        }
    }
    
    public function getFileFields()
    {
        return $this->_fileFields;
    }   
    
    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->files = UploadedFile::getInstances($this, 'files');
            return true;
        }
        return false;
    }

    public function getViewParameters(): array
    {   
        return [];
    }
}
