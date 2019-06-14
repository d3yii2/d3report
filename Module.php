<?php

namespace d3yii2\d3report;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'd3yii2\d3report\controllers';

    public function getLabel(){
        return Yii::t('d3report','d3report');
    }
}
