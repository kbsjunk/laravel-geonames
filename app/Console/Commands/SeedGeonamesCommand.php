<?php

namespace App\Console\Commands;

use Illuminate\Database\Console\Seeds\SeedCommand;
use Symfony\Component\Console\Input\InputOption;

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
        parent::__construct(app('db'));
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        $options = [
            ['language', null, InputOption::VALUE_REQUIRED, 'Seed the specified language file.'],
        ];

        return array_merge($options, parent::getOptions());
    }

}
