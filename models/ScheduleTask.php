<?php

namespace d3yii2\d3schedule\models;

use \d3yii2\d3schedule\models\base\ScheduleTask as BaseScheduleTask;

/**
 * This is the model class for table "schedule_schedule".
 */
class ScheduleTask extends BaseScheduleTask
{

    /** @var string */
    public $monthDay;

    /** @var string */
    public $weekDay;

    /** @var string */
    public $hour;

    /** @var string */
    public $minute;


}
