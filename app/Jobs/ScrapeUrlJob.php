<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Queue\ShouldQueue;
use Goutte\Client;
use File;
use Exception;

class ScrapeUrlJob extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    use DispatchesJobs;

    protected $url;
    protected $name;
    protected $type;
    protected $client;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($url, $name, $type)
    {
        $this->url = $url;
        $this->name = str_slug($name);
        $this->type = str_slug($type);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->client = new Client;

       $crawler = $this->client->request('GET', $this->url);

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

        $path = storage_path('geopostcodes/'.$this->type);

        File::makeDirectory($path, 0755, true, true);

        $file = storage_path($path.'/'.$this->name.'.json');

        File::put($file, json_encode($result, JSON_PRETTY_PRINT));

        $job = new ScrapeUrlJob($file, S::class);

        $this->dispatch($job);

    }
}
