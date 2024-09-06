<?php
namespace App\Scheduler\Handler;

use App\Scheduler\Message\WeeklyStatisticMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class WeeklyStatisticHandler
{
    public function __invoke(WeeklyStatisticMessage $message)
    {

    }
}
