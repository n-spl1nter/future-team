<?php

namespace App\Console\Commands\Database;

use Illuminate\Console\Command;

class PlacesSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'places:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed database with places';

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
        $path = base_path('database/sql/_countries.sql');
        $this->info("Start seed $path");
        $content = @file_get_contents($path);
        $res = \DB::unprepared($content);
        $this->info("Seed completed $res");
    }
}
