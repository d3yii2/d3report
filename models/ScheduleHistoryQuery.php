<?php

namespace d3yii2\d3schedule\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[scheduleHistory]].
 *
 * @see scheduleHistory
 */
class ScheduleHistoryQuery extends ActiveQuery
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
}
