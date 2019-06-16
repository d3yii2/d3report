<?php

namespace d3yii2\d3schedule\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[scheduleschedule]].
 *
 * @see ScheduleTask
 */
class ScheduleTaskQuery extends ActiveQuery
{


    /**
    * @param string $fieldName
    * @param string $dateRange
    * @return self
    */
    public function andFilterWhereDateRange(string $fieldName, $dateRange): self
    {
        if(empty($dateRange)){
            return $this;
        }

        $list = explode(' - ', $dateRange);
        if(count($list) !== 2){
            return $this;
        }

        return $this->andFilterWhere(['between', $fieldName, $list[0], $list[1]]);
    }

    public function active(): self
    {
        return $this->andWhere(['schedule_schedule.status' => ScheduleTask::STATUS_ACTIVE]);
    }

    public function joinSubscriberActive(): self
    {
        return $this
            ->addSelect([
                'subscriberFormat' => 'subscriber.format'
            ])
            ->innerJoin(
            'schedule_subscriber subscriber',
            'schedule_schedule.id = subscriber.schedule_id'
            )
            ->andWhere(['subscriber.status' => ScheduleSubscriber::STATUS_ACTIVE]);
    }

    public function joinSchedule(): self
    {
        return $this
            ->addSelect([
                'monthDay' => 'schedule.month_day',
                'weekDay' => 'schedule.week_day',
                'hour' => 'schedule.hour',
                'minute' => 'schedule.minute'
            ])
            ->innerJoin(
                'schedule_schedule schedule',
                'subscriber.id=schedule.subscriber_id'
            );
    }
}
