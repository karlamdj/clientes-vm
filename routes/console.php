<?php

use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\SendPaymentReminders;


Schedule::command(SendPaymentReminders::class)->dailyAt('09:00');