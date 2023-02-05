<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\StoreHoursLoginCron::class,
        Commands\ResendNotificationCron::class,
        Commands\PriceDropNotificationCron::class,
        Commands\ProductImport::class,
        Commands\PaidModuleChangeStatusCron::class,
        Commands\CancelArchiveCron::class,
        Commands\ReturnArchiveCron::class,
        Commands\CustomerDeactivateCron::class,
        Commands\RenewCustomerSubscription::class,
        Commands\RenewCustomerSubscription3DaysBefore::class,
        Commands\RenewCustomerSubscription5DaysBefore::class,
        Commands\CancelCustomerSubscription::class,
        Commands\CustomerIncentiveQualifier::class,
        Commands\CustomerIncentiveWinner::class,
        Commands\MaintainCustomerWalletAmount::class,
        Commands\VendorInventoryReminder::class,
        Commands\CustomerChecklistReminder::class,
        Commands\ParticipationExpired::class,
        Commands\WeeklyRetailerRegister::class,
        Commands\WeeklyCustomerRegister::class,
        Commands\WeeklySuggestedStore::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('store_hours_login:cron')->everyMinute();

        $schedule->command('retailer_register:weekly')->weekly();
        $schedule->command('customer_register:weekly')->weekly();
        $schedule->command('suggested_store:weekly')->weekly();

        $schedule->command('notification:price_drop')->everyFifteenMinutes();
        $schedule->command('notification:resend')->everyFifteenMinutes();
        $schedule->command('product:import')->everyThirtyMinutes();
        $schedule->command('paid_module_change_status:cron')->daily();
        $schedule->command('cancel_archive:cron')->daily();
        $schedule->command('return_archive:cron')->daily();
        $schedule->command('customer_deactivate:cron')->daily();
        $schedule->command('customer_subscription:renew')->daily();
        $schedule->command('customer_subscription:renew_3_days_before')->daily();
        $schedule->command('customer_subscription:renew_5_days_before')->daily();
        $schedule->command('customer_subscription:cancel')->daily();
        // $schedule->command('customer_incentive:qualifiers')->monthly();
        // $schedule->command('customer_incentive:winners')->monthlyOn(1, '6:00');
        $schedule->command('customer_wallet:maintain')->daily();
        $schedule->command('vendor_inventory:reminder')->everyFifteenMinutes();
        $schedule->command('customer_checklist:reminder')->dailyAt('6:00');
        $schedule->command('participation:expired')->daily();
        $schedule->command('queue:work --daemon')->everyMinute()->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
