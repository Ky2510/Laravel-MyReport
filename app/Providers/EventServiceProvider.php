<?php

namespace App\Providers;

use App\Events\AttendanceEvent;
use App\Events\BranchEvent;
use App\Events\DepartmentEvent;
use App\Events\EmployeeEvent;
use App\Events\LeaveEvent;
use App\Events\ReportEvent;
use App\Events\RuleScheduleEvent;
use App\Events\ScheduleGenerateEvent;
use App\Events\TitleEvent;
use App\Listeners\AttendanceEventListener;
use App\Listeners\BranchEventListener;
use App\Listeners\DepartmentEventListener;
use App\Listeners\EmployeeEventListener;
use App\Listeners\LeaveEventListener;
use App\Listeners\ReportEventListener;
use App\Listeners\RuleScheduleEventListener;
use App\Listeners\ScheduleGenerateEventListener;
use App\Listeners\TitleEventListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        LeaveEvent::class => [
            LeaveEventListener::class,
        ],

        ReportEvent::class => [
            ReportEventListener::class
        ],

        DepartmentEvent::class => [
            DepartmentEventListener::class
        ],

        BranchEvent::class => [
            BranchEventListener::class
        ],

        AttendanceEvent::class => [
            AttendanceEventListener::class
        ],

        EmployeeEvent::class => [
            EmployeeEventListener::class
        ],

        RuleScheduleEvent::class => [
            RuleScheduleEventListener::class
        ],

        ScheduleGenerateEvent::class => [
            ScheduleGenerateEventListener::class
        ],

        TitleEvent::class => [
            TitleEventListener::class
        ],

    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
