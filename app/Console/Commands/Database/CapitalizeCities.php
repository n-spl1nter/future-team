<?php

namespace App\Console\Commands\Database;

use App\Entities\City;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CapitalizeCities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cities:capitalize {countryId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Capitalize cities words';

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
        $countryId = $this->argument('countryId');
        $citiesQuery = City::whereCountryId($countryId);
        $citiesQuery->chunk(200, function ($cities) {
            /** @var City $city */
            foreach ($cities as $city) {
                $city->title_en = implode(' ', array_map(function ($piece) {
                    return Str::ucfirst($piece);
                }, explode(' ', $city->title_en)));
                $city->save();
                var_dump($city->title_en);
            }
        });
    }
}
