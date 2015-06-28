<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Queue\ShouldQueue;
use File;

class ReadScrapedFilesJob extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    use DispatchesJobs;

    protected $file;
    protected $command;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file, $slug, $command)
    {
        $this->file = $file;
        $this->comand = $command;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $file = File::get($this->file);

        $contents = json_decode($file);

        foreach ($contents as $item) {
            $type = $item->type;

            if (isset($item->children)) {
                foreach ($item->children as $child) {
                    $name = $item->name;
                    $url = $item->url;

                    

                }
            }

        }
    }
}
