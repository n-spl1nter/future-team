<?php

namespace App\Console\Commands\Database;

use App\Entities\City;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class TranslateRussianCities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cities:translate {countryId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Trasnalte cities';

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
                $city->title_en = Str::ucfirst(Str::slug($city->title_ru, ' '));
                $city->save();
            }
        });
    }
}
