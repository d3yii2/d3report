<?php

namespace d3yii2\d3schedule;

use Yii;

/**
 *
 * @property mixed $label
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'd3yii2\d3schedule\controllers';

    public function getLabel(): string
    {
        return Yii::t('d3schedule','d3schedule');
    }
}
