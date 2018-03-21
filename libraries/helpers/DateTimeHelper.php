<?php

namespace app\libraries\helpers;

class DateTimeHelper
{
    /**
     * @param $datetime \DateTime
     */
    public static function applyDateTimeOffset($datetime, $offset)
    {
        $timeZone = $offset;
        $currentTZ = new \DateTimeZone(\Yii::$app->timeZone);

        $utcTimezone = new \DateTimeZone('UTC');
        $utcNow = new \DateTime('now', $utcTimezone);

        $currentOffset = $currentTZ->getOffset($utcNow) / 3600;

        $offset = $timeZone - $currentOffset;

        if ($offset > 0) {
            $datetime->add(new \DateInterval('PT' . $offset . 'H'));
        } else if ($offset < 0) {
            $datetime->sub(new \DateInterval('PT' . abs($offset) . 'H'));
        }

        return $datetime;
    }
}