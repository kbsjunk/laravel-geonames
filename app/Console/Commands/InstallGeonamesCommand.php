<?php

namespace App\Console\Commands;

use ErrorException;
use RuntimeException;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Process\Process;

use ZipArchive;
use File;

class InstallGeonamesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geonames:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download and install Geonames files.';

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
        
        $this->doMigrate();
        // $this->doFeatureClasses();
        // $this->doAdmin1Codes();
        // $this->doAdmin2Codes();

    }

    protected function doMigrate()
    {
        $this->info('Migrating Geonames tables.');

        $this->call('migrate');
    }

    protected function doFeatureClasses()
    {
       $this->info('Downloading Feature Class tables.');

       $url = $this->buildUrl('feature_codes', ['locale' => 'en']);

       $this->info('- en');

       $this->downloadFile($url, storage_path('geonames'));

       $this->doSeed('FeatureClassSeeder');

       $languages = config('geonames.available.feature_code_locales');

       foreach ($languages as $language) {

            $url = $this->buildUrl('feature_codes', ['locale' => $language]);

            $this->info('- ' . $language);

            $this->downloadFile($url, storage_path('geonames'));

            $this->doSeed('FeatureClassNamesSeeder', "--language=$language");

        }

    }

    protected function doAdmin1Codes()
    {
        $this->info('Downloading Admin 1 Codes table.');

        $url = $this->buildUrl('admin1_codes');

        $this->downloadFile($url, storage_path('geonames'));

        $this->doSeed('Admin1CodesSeeder');
    }

    protected function doAdmin2Codes()
    {
        $this->info('Downloading Admin 2 Codes table.');

        $url = $this->buildUrl('admin2_codes');

        $this->downloadFile($url, storage_path('geonames'));

        $this->doSeed('Admin2CodesSeeder');
    }

    protected function buildUrl($file, $replacements = [])
    {
        $url = config('geonames.urls.base') . config('geonames.urls.'.$file);

        foreach ($replacements as $key => $value) {
            $url = str_replace('{'.$key.'}', $value, $url);
        }

        return $url;
    }

    /**
     * Seed the chosen class file in a separate process.
     *
     * @param  string  $class
     * @return void
     */
    protected function doSeed($class, $options = null)
    {
        $command = 'php artisan geonames:seed --class="'.$class.'" '.$options;
        
        $process = new Process($command, base_path(), null, null, 0);

        $process->run();

        if ( ! $process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        $this->info("Seeded: $class");
    }

    /**
     * Download a file from a remote URL to a given path.
     *
     * @param  string  $url
     * @param  string  $path
     * @return void
     */
    protected function downloadFile($url, $path, $filename = null)
    {
        $filename = $filename ?: basename($url);

        if (false && $this->fileExists($path, $filename)) {
            if (!$this->confirm('The file "'.$filename.'" already exists.' . PHP_EOL .
                'Do you want to download it again? [yes|no]', false))
            {
                return;
            }
        }

        if ( ! $fp = fopen ($path . '/' . $filename, 'w+')) {
            throw new RuntimeException('Cannot write to path: ' . $path);
        }
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
    }

    protected function fileExists($path, $filename)
    {
        if (file_exists($path . '/' . $filename)) {
            return true;
        }

        if (file_exists($path . '/' . str_replace('.zip', '.txt', $filename))) {
            return true;
        }

        return false;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['country', null, InputOption::VALUE_REQUIRED, 'Download files for specific countries, comma separated.'],
            // array('development', null, InputOption::VALUE_NONE, 'Downloads an smaller version of names (~10MB).'),
            // array('fetch-only', null, InputOption::VALUE_NONE, 'Just download the files.'),
            // array('wipe-files', null, InputOption::VALUE_NONE, 'Wipe old downloaded files and fetch new ones.'),
        ];
    }
}
