<?php
namespace App\Scheduler;

use App\Scheduler\Message\WeeklyStatisticMessage;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;

#[AsSchedule(name: 'default')]
class WeeklyStatisticProvider implements ScheduleProviderInterface
{
    public function getSchedule(): Schedule
    {
        /// Scheduler defined by attributes in the command class
        return (new Schedule());
    }
}
