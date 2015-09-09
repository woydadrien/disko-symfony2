<?php

namespace Disko\CoreBundle\Services;

use Doctrine\ORM\Query\ResultSetMapping;

/**
 * Class DateService
 *
 * Object manager of user
 *
 * @package Disko\CoreBundle\Services
 */
class DateService extends BaseService
{
    public function dates($groupBy = 'day', $max = 30)
    {
        $data = array(
            'year' =>   array(
                'format' => '%Y-00-00 00:00:00',
                'interval' => 'YEAR',
            ),
            'month' =>  array(
                'format' => '%Y-%m-01 00:00:00',
                'interval' => 'DAY',
            ),
            'week' =>   array(
                'format' => '%Y-%u',
                'interval' => 'DAY',
            ),
            'day' =>    array(
                'format' => '%Y-%m-%d 00:00:00',
                'interval' => 'DAY',
            ),
            'hour' =>   array(
                'format' => '%Y-%m-%d %H:00:00',
                'interval' => 'HOUR',
            ),
            'minute' => array(
                'format' => '%Y-%m-%d %H:%i:00',
                'interval' => 'SECOND',
            ),
            'second' => array(
                'format' => '%Y-%m-%d %H:%i:%s',
                'interval' => 'SECOND',
            ),
        );

        if(!in_array($groupBy, array_keys($data))) $groupBy = 'day';
        $format = function ($field, $alias) use ($data, $groupBy) {
            return 'DATE_FORMAT('.$field.', \''.$data[$groupBy]['format'].'\') AS '.$alias;
        };
        $interval = $data[$groupBy]['interval'];

        $sqlDates = 'select '.$format('a.Date', 'd').'  from (
            select CURRENT_TIMESTAMP() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) '.$interval.' as Date
            from (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as a
            cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as b
            cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as c
        ) a
        GROUP BY d
        ORDER BY a.Date DESC
        LIMIT :max';

        $rsmDates = new ResultSetMapping();
        $rsmDates->addScalarResult('d', 'd');
        $qbDates = $this->em->createNativeQuery($sqlDates, $rsmDates)
            ->setParameter('max', $max)
        ;
        $dates = array_map('current', $qbDates->getResult());

        return array(
            'dates' => $dates,
            'format' => $format,
            'interval' => $interval,
        );
    }
}
