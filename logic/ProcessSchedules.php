<?php

namespace d3yii2\d3schedule\logic;

use d3yii2\d3schedule\models\ScheduleTask;
use DateTime;

use Yii;

class ProcessSchedules
{


    /** @var DateTime */
    public $runTime;

    /**
     * CreateChedule constructor.
     * @param DateTime $runTime
     */
    public function __construct(DateTime $runTime)
    {
        $this->runTime = $runTime;
    }

    public function run(): void
    {
        foreach($this->getSchedulingList() as $schedule){
            $this->do($schedule);
        }
    }

    public function getSchedulingList()
    {
        return  ScheduleTask::find()
            ->select('*')
            ->active()
            ->joinSubscriberActive()
            ->joinSchedule()
            ->all()
        ;

    }

    public function do(ScheduleTask $task)
    {


        if(!$this->isActualTime($task)){
            return false;
        }
        return Yii::$app->runAction($task->command,$task->command_params);

    }

    public function isActualTime(ScheduleTask $task): bool
    {
        if ($task->monthDay) {
            $monthDays = explode(',', $task->monthDay);
            if (!in_array($this->runTime->format('j'), $monthDays, true)) {
                return false;
            }
        }

        if ($task->weekDay) {
            $weekDays = explode(',', $task->weekDay);
            if (!in_array($this->runTime->format('N'), $weekDays, true)) {
                return false;
            }
        }

        if ($task->minute) {
            $minutes = explode(',', $task->minute);
            $actualMinute = ltrim($this->runTime->format('i'), '0');
            if (!in_array($actualMinute, $minutes, true)) {
                return false;
            }
        }
        if ($task->hour) {
            $hours = explode(',', $task->hour);
            $actualHour = ltrim($this->runTime->format('G'));
            if (!in_array($actualHour, $hours, true)) {
                return false;
            }
        }

        return true;
    }
}