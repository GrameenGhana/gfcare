<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spark:install {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Spark scaffolding for the application';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->installEnvironmentVariables();
        $this->installTerms();
        $this->call('key:generate');

        $this->table(
            ['Task', 'Status'],
            [
                ['Installing Spark Features', '<info>✔</info>'],
            ]
        );

        if ($this->option('force') || $this->confirm('Would you like to run your database migrations?', 'yes')) {
            (new Process('php artisan migrate', base_path()))->setTimeout(null)->run();
        }

        if ($this->option('force') || $this->confirm('Would you like to install your NPM dependencies?', 'yes')) {
            (new Process('npm install', base_path()))->setTimeout(null)->run();
        }

        if ($this->option('force') || $this->confirm('Would you like to run Gulp?', 'yes')) {
            (new Process('gulp', base_path()))->setTimeout(null)->run();
        }

        $this->displayPostInstallationNotes();
    }

    /**
     * Install the environment variables for the application.
     *
     * @return void
     */
    protected function installEnvironmentVariables()
    {
        if (! file_exists(base_path('.env'))) {
            return;
        }

        $env = file_get_contents(base_path('.env'));

        if (str_contains($env, 'AUTHY_KEY=')) {
            return;
        }

        (new Filesystem)->append(
            base_path('.env'),
            PHP_EOL.'AUTHY_KEY='.PHP_EOL.PHP_EOL.
            'STRIPE_KEY='.PHP_EOL.
            'STRIPE_SECRET='.PHP_EOL
        );
    }

    /**
     * Install the "Terms Of Service" Markdown file.
     *
     * @return void
     */
    protected function installTerms()
    {
        file_put_contents(
            base_path('terms.md'), 'This page is generated from the `terms.md` file in your project root.'
        );
    }

    /**
     * Display the post-installation information to the user.
     *
     * @return void
     */
    protected function displayPostInstallationNotes()
    {
        $this->comment('Post Installation Notes:');
        $this->line(PHP_EOL.'     → Set <info>AUTHY_KEY</info>, <info>STRIPE_KEY</info>, & <info>STRIPE_SECRET</info> Environment Variables');
    }
}
