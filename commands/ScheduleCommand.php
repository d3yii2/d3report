<?php

namespace d3yii2\d3schedule\commands;

use d3yii2\d3schedule\models\ScheduleTask;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\Connection;
use yii\helpers\VarDumper;

/**
 *
 * @property Connection $connection
 */
class ScheduleCommand extends Controller
{

    /**
     * default action
     * @return int
     */
    public function actionIndex(): int
    {
        $this->out('Started ' . date('Ymd His') );
        //$connection = $this->getConnection();

        $schedulescheduleQuery = ScheduleTask::find()
            ->select('*')
            ->active()
            ->joinSubscriberActive()
            ->joinSchedule();

        $data = $schedulescheduleQuery->all();

        echo VarDumper::dumpAsString($data);

//        foreach ($data as $row){
//
//        }

        $this->out('Finished ' . date('Ymd His') );
        return ExitCode::OK;
    }

    /**
     * @return Connection
     */
    private function getConnection(): Connection
    {
        return Yii::$app->getDb();
    }

    /**
     * output to terminal line
     * @param string $string output string
     * @param int $settings
     */
    public function out(string $string,int $settings = 0): void
    {
        $this->stdout($string . PHP_EOL, $settings);
    }

}

