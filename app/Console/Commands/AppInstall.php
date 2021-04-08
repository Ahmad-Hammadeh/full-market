<?php

namespace App\Console\Commands;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class AppInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install {--force : Trigger The Command Without Conformation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Dummy Data For The Application';

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
     * @return int
     */
    public function handle()
    {
        if ($this->option('force')) {

            $this->install_dummy_data();

        }else{

            if ($this->confirm('Are you want to install dummy data and remove the previous data if there is ?')) {

                $this->install_dummy_data();

            }

        }
    }

    private function install_dummy_data()
    {
        // Clear The Shopping Cart
        Cart::instance('default')->destroy();
        Cart::instance('save_for_later')->destroy();

        // Delete Previous Images
        File::deleteDirectory(public_path('storage/general'));
        File::deleteDirectory(public_path('storage/users'));
        File::deleteDirectory(public_path('storage/settings'));
        File::deleteDirectory(public_path('storage/products'));

        // Create The Storage Link
        $this->callSilent('storage:link');

        // Copy Dummy Images To Project Storage
        File::copyDirectory(public_path('dummy_images/general'), public_path('storage/general'));
        File::copyDirectory(public_path('dummy_images/users'), public_path('storage/users'));
        File::copyDirectory(public_path('dummy_images/settings'), public_path('storage/settings'));
        $copy = File::copyDirectory(public_path('dummy_images/products'), public_path('storage/products'));

        if( $copy ){
            $this->info('Images successfully copied to storage folder');
        }

        // Handling The Database

        // After Using Algolia
        try {
            $this->call('migrate:fresh', [
                '--seed' => true,
                '--force' => true,
            ]);
        } catch (\Exception $e) {
            $this->error('Algolia credentials incorrect. Your products table is NOT seeded correctly. If you are not using Algolia, remove Laravel\Scout\Searchable from App\Product');
        }

        $this->call('db:seed', [
            '--class' => 'VoyagerDatabaseSeeder',
            '--force' => true
        ]);

        // After Using Algolia
        try {
            $this->call('scout:flush', [
                'model' => 'App\Model\Product',
            ]);

            $this->call('scout:import', [
                'model' => 'App\Model\Product',
            ]);
        } catch (\Exception $e) {
            $this->error('Algolia credentials incorrect. Check your .env file. Make sure ALGOLIA_APP_ID and ALGOLIA_SECRET are correct.');
        }

        $this->info('Dummy data has installed successfully');
    }
}
