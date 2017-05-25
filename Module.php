<?php

namespace backend\modules\importadorCSV;

class Module extends \yii\base\Module
{
    const MODULE = "importForm";
    
    public $controllerNamespace = 'backend\modules\importadorCSV\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
