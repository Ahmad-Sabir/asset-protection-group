<?php

namespace App\Providers;

use App\Events\Imported;
use App\Listeners\SendImportEmail;
use App\Events\CompanyCreated;
use App\Events\Export;
use App\Listeners\SendEmailWelcomeNotification;
use App\Events\Registered;
use App\Listeners\CompanyNotification;
use App\Listeners\ExportCsvSendListener;
use App\Listeners\ExportPdfSendListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\WorkOrder;
use App\Listeners\WorkOrder\SendEmail;
use App\Listeners\WorkOrder\SendNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailWelcomeNotification::class,
        ],
        Imported::class => [
            SendImportEmail::class,
        ],
        CompanyCreated::class => [
            CompanyNotification::class,
        ],
        Export::class => [
            ExportPdfSendListener::class,
            ExportCsvSendListener::class
        ],
        WorkOrder::class => [
            SendEmail::class,
            SendNotification::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
