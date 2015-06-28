<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Jobs\ReadScrapedFilesJob;

use Goutte\Client;
use File;
use Artisan;

class ScrapeCountriesCommand extends Command
{

    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape country data.';

    protected $client;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Client $client)
    {
        parent::__construct();

        $this->client = $client;

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $crawler = $this->client->request('GET', 'http://www.geopostcodes.com/data');

        $result = [[
            'type'     => 'Countries',
            'children' => $crawler->filter('[itemscope][itemtype="http://schema.org/Country"] a[itemprop="name"]')->each(function ($node) {

                return [
                    'name' => $node->text(),
                    'url'  => $node->link()->getUri()
                ];

            })
        ]];

        $path = storage_path('geopostcodes');

        File::makeDirectory($path, 0755, true, true);

        $file = $path.'/countries.json';

        File::put($file, json_encode($result, JSON_PRETTY_PRINT));

        $job = new ReadScrapedFilesJob($file, 'countries', 'scrape:division');

        $this->dispatch($job);

    }
}
