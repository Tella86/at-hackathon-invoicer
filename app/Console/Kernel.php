<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * By default, Laravel automatically discovers and registers commands,
     * so you usually don't need to add them here unless you want to
     * register them manually.
     *
     * @var array
     */
    protected $commands = [
        // Commands are auto-discovered, so this array can often be left empty.
        // If you created your command correctly (e.g., App\Console\Commands\SendOverdueInvoiceReminders),
        // Laravel will find it.
    ];

    /**
     * Define the application's command schedule.
     *
     * This is the method where you tell Laravel what tasks to run and how often.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // ======================================================================
        // === YOUR HACKATHON CODE GOES HERE ===
        // ======================================================================
        // This line tells Laravel to execute the 'invoices:remind' Artisan command.
        // The 'invoices:remind' signature was defined in your SendOverdueInvoiceReminders command.
        // The '->dailyAt('09:00')' part specifies the frequency.
        // It will run this command every day at 9:00 AM server time.

        $schedule->command('invoices:remind')->dailyAt('09:00');

        // ======================================================================
        // === EXAMPLES OF OTHER FREQUENCIES (FOR YOUR KNOWLEDGE) ===
        // ======================================================================

        // $schedule->command('inspire')->hourly(); // Run a command every hour
        // $schedule->command('backup:clean')->daily(); // Run daily at midnight
        // $schedule->command('telescope:prune')->daily(); // A common maintenance task
        // $schedule->command('reminders:send')->everyMinute(); // Run every single minute
        // $schedule->command('reports:generate')->mondays()->at('08:00'); // Run only on Mondays at 8 AM
    }

    /**
     * Register the commands for the application.
     *
     * This method is called to load your command files so they can be executed.
     * The default implementation handles this automatically.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
