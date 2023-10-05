<?php

Yii::setAlias('@views', dirname(__DIR__) . DIRECTORY_SEPARATOR . 
        'app' .DIRECTORY_SEPARATOR .'views');
Yii::setAlias('@blocks', dirname(__DIR__) . DIRECTORY_SEPARATOR . 
        'app' .DIRECTORY_SEPARATOR . 'views' .
        DIRECTORY_SEPARATOR .'blocks');
Yii::setAlias('@modules', dirname(__DIR__) . DIRECTORY_SEPARATOR . 
        'app' .DIRECTORY_SEPARATOR .'modules');
Yii::setAlias('@mail', dirname(__DIR__) . DIRECTORY_SEPARATOR . 
        'app' .DIRECTORY_SEPARATOR .'views' . DIRECTORY_SEPARATOR . 'mail');
Yii::setAlias('@pdf', dirname(__DIR__) . DIRECTORY_SEPARATOR . 
        'app' .DIRECTORY_SEPARATOR .'views' . DIRECTORY_SEPARATOR . 
        'templates'. DIRECTORY_SEPARATOR . 'pdf');
Yii::setAlias('@elements', dirname(__DIR__) . DIRECTORY_SEPARATOR . 
        'app' .DIRECTORY_SEPARATOR .'views' . DIRECTORY_SEPARATOR . 
        'templates'. DIRECTORY_SEPARATOR . 'elements');
Yii::setAlias('@fields', dirname(__DIR__) . DIRECTORY_SEPARATOR . 
        'app' .DIRECTORY_SEPARATOR .'views' . DIRECTORY_SEPARATOR . 
        'templates'. DIRECTORY_SEPARATOR . 'fields');
Yii::setAlias('@fixtures', dirname(__DIR__) . DIRECTORY_SEPARATOR .
        'commands' . DIRECTORY_SEPARATOR . 'fixtures');

Yii::setAlias('@config', dirname(__DIR__) . DIRECTORY_SEPARATOR .
        'config' . DIRECTORY_SEPARATOR . 'parts');
Yii::setAlias('@uploadPath', dirname(__DIR__)
        . DIRECTORY_SEPARATOR . 'web' 
        . DIRECTORY_SEPARATOR . 'upload'
        );
Yii::setAlias('@standUploadPath', dirname(__DIR__)
        . DIRECTORY_SEPARATOR . 'web' 
        . DIRECTORY_SEPARATOR . 'upload'
        . DIRECTORY_SEPARATOR . 'stand'
        );
Yii::setAlias('@formsUploadPath', dirname(__DIR__)
        . DIRECTORY_SEPARATOR . 'web' 
        . DIRECTORY_SEPARATOR . 'upload'
        . DIRECTORY_SEPARATOR . 'forms'
        );
Yii::setAlias('@attachedPath', dirname(__DIR__)
        . DIRECTORY_SEPARATOR . 'web' 
        . DIRECTORY_SEPARATOR . 'upload'
        . DIRECTORY_SEPARATOR . 'forms'
        . DIRECTORY_SEPARATOR . 'attached'
        );
Yii::setAlias('@documentsUploadPath', dirname(__DIR__)
        . DIRECTORY_SEPARATOR . 'web' 
        . DIRECTORY_SEPARATOR . 'upload'
        . DIRECTORY_SEPARATOR . 'documents'
        );
Yii::setAlias('@logoUploadPath', dirname(__DIR__)
        . DIRECTORY_SEPARATOR . 'web' 
        . DIRECTORY_SEPARATOR . 'upload'
        . DIRECTORY_SEPARATOR . 'logo'
        );
Yii::setAlias('@uploadUrl','/upload');
Yii::setAlias('@standUploadUrl','/upload/stand');
Yii::setAlias('@formsUploadUrl','/upload/forms');
Yii::setAlias('@attachedUrl','/upload/forms/attached');
Yii::setAlias('@documentsUploadUrl','/upload/documents');
Yii::setAlias('@logoUploadUrl','/upload/logo');