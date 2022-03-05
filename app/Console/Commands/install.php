<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;
use TCG\Voyager\VoyagerServiceProvider;
use Database\Seeders\DatabaseSeederEShop;

class install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ecommerce:install
                            {--r|reset : Reset database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Laravel Ecommerce';

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
        if($this->option('reset')){
            $this->call('migrate:fresh');
            $this->call('db:seed', ['--class' => DatabaseSeederEShop::class]);
            $this->info('La base de datos de Laravel Ecommerce ha sido reiniciada ;)');
        }else{
            
            $empty_database = false;
            try {
                DB::table('users')->get();
            } catch (\Throwable $th) {
                $empty_database = true;
            }

            if(!$empty_database){
                $this->call('key:generate');
                $this->call('migrate');
                $this->call('db:seed', ['--class' => DatabaseSeederEShop::class]);
                $this->call('storage:link');
                $this->call('vendor:publish', ['--provider' => VoyagerServiceProvider::class, '--tag' => ['config', 'voyager_avatar']]);
                $this->info('Gracias por instalar Laravel Ecommerce!!!');
            }else{
                $this->error('La base de datos de Laravel Ecommerce ya está instalada.');
            }
        }
    }
}
