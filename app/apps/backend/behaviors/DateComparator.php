<?php

class DateComparator extends CActiveRecordBehavior
{

    /**
     * compares date field with range or without
     *
     * @param $criteria
     * @param $fieldName
     */
    public function compareDate($criteria, $fieldName) {
        $owner = $this->owner;
        $fieldNameStart = $fieldName.'_start';
        $fieldNameEnd = $fieldName.'_end';

        if (!empty($owner->{$fieldNameStart}) || !empty($owner->{$fieldNameEnd})) {
            if (!empty($owner->{$fieldNameStart})) {
                $criteria->compare('t.'.$fieldName, '>= '.$owner->{$fieldNameStart}.' 00:00:00', true);
            }
            if (!empty($this->{$fieldNameEnd})) {
                $criteria->compare('t.'.$fieldName, '<= '.$owner->{$fieldNameEnd}.' 23:59:59', true);
            }
        }
        else {
            $criteria->compare('t.'.$fieldName, $owner->{$fieldName}, true);
        }
    }

}