<?php namespace App\Console\Commands;

use Illuminate\Database\Console\Seeds\SeedCommand;

class SeedGeonamesCommand extends SeedCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geonames:seed';

    public function __construct()
    {
        parent::__construct($this->app['db']);
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        $options = [
            ['language', null, InputOption::VALUE_REQUIRED, 'Seed the specifed language file.']
        ];

        return array_merge($options, parent::getOptions());
    }
}
