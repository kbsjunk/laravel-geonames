<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Jobs\ReadScrapedFilesJob;

use Goutte\Client;
use File;
use Exception;

class ScrapeDivisionCommand extends Command
{

    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:division
                            {--name= : The name of the division.}
                            {--type= : The type of the division.}
                            {--url= : The URL of the division\'s data.}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape a single division\'s data.';

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
        $crawler = $this->client->request('GET', $this->option('url'));

        if (!count($node->filter('[itemscope][itemtype="http://schema.org/AdministrativeArea"]'))) {
            
            $this->error('No administrative divisions to scrape.');

            return;
        }

        $result = $crawler->filter('table#browser table.list2')->each(function($node) {

            return [
                'type' => $node->filter('tr:first-child th')->first()->text(),
                'children' => $node->filter('[itemscope][itemtype="http://schema.org/AdministrativeArea"]')->each(function ($node) {

                    $area = $node->filter('a[itemprop="name"]')->first();

                    try {
                        $name = $area->text();
                        $url = $area->link()->getUri();
                    }
                    catch (Exception $e) {
                        $area = $node->filter('[itemprop="name"]')->first();
                        try {
                            $name = $area->text();
                            $url = null;
                        }
                        catch (Exception $e) {
                            $name = null;
                            $url = null;
                        }
                    }

                    return [
                        'name' => $name,
                        'url'  => $url,
                        'codes' => $node->filter('div.code')->each(function($node) {
                            return [
                                'type' => str_replace('code ', '', $node->attr('class')),
                                'code' => $node->text(),
                            ];
                        })
                    ];

                    
                })
            ];

        });

        $path = storage_path('geopostcodes/'.$this->option('type'));

        File::makeDirectory($path, 0755, true, true);

        $file = storage_path($path.'/'.$this->option('name').'.json');

        File::put($file, json_encode($result, JSON_PRETTY_PRINT));

        // $job = new ReadScrapedFilesJob($file, ScrapeCountryCommand::class);

        // $this->dispatch($job);
    }

}
