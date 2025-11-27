<?php

namespace Tests\Unit;

use App\Services\DateService;
use Tests\TestCase;

class DateServiceTest extends TestCase
{
    public function test_add_working_days()
    {
        $date = DateService::addWorkingDays('2025-01-06', 5);

        $this->assertEquals('2025-01-13', $date);
    }
}
