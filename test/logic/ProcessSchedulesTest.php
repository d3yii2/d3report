<?php

namespace d3schedule\test\logic;

use d3yii2\d3schedule\logic\ProcessSchedules;
use d3yii2\d3schedule\models\ScheduleTask;
use DateTime;
use PHPUnit\Framework\TestCase;

class ProcessSchedulesTest extends TestCase
{

//    public function testGetSchedulingList()
//    {
//
//    }
//

    /**
     * @dataProvider  providerIsActualTime
     */
    public function testIsActualTime($dateTime, $monthDay, $weekDay, $hour, $minute, $asserEqual, $message)
    {
        $task = new ScheduleTask();
        $task->monthDay= $monthDay;
        $task->weekDay = $weekDay;
        $task->minute = $minute;
        $task->hour = $hour;

        $ps = new ProcessSchedules($dateTime);
        $r = $ps->isActualTime($task);
        $this->assertEquals($asserEqual, $r, $message);

    }

    public function testDo()
    {
        $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', '2019-06-16 10:00:00');
        $ps = new ProcessSchedules($dateTime);
        $task = new ScheduleTask();
        $task->command = 'd3schedule/test';
        $task->command_params = ['test'];
        $r = $ps->do($task);
        $this->assertEquals(0,$r);
    }

    public function providerIsActualTime()
    {
        $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', '2019-06-16 10:00:00');
        return [
            [$dateTime, null, null, '10', '0', true,'* * 10 0'],
            [$dateTime, null, null, '10', '0,10', true,'* * 10 0,10'],
            [$dateTime, null, null, '10', '1', false,'* * 10 1'],
            [$dateTime, null, null, '10', '1,11', false,'* * 10 1,11'],
            [$dateTime, null, null, '11', '0', false,'* * 11 0'],
            [$dateTime, null, null, '11,12', '0', false,'* * 11,12 0'],
            [$dateTime, null, null, '11', null, false,'* * 10 *'],
            [$dateTime, null, null, '10,11', null, true,'* * 10,11 *'],
            [$dateTime, null, null, null, '0', true,'* * * 0'],
            [$dateTime,   '16', null, '10', '0', true,'16 * 10 0'],
            [$dateTime,   '17', null, '10', '0', FALSE,'17 * 10 0'],
            [$dateTime, NULL, '7', '10', '0', true,'* 7 10 0'],
            [$dateTime, NULL, '6', '10', '0', false,'* 6 10 0'],
        ];
    }


}
