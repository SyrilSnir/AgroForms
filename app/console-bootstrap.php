<?php
Yii::setAlias('@rbac', dirname(__DIR__) . '\data\rbac');

Yii::setAlias('@fixtures', dirname(__DIR__) . DIRECTORY_SEPARATOR .
        'commands' . DIRECTORY_SEPARATOR . 'fixtures');
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