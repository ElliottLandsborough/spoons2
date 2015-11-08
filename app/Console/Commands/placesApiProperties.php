<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

use App\Pub;

class placesApiProperties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'placesApiProperties';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download the json file from the spoons website';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $pubs = Pub::get();

        $this->info('Indexing pubs...');

        $bar = $this->output->createProgressBar(count($pubs));

        foreach ($pubs as $pub) {
            $bar->advance();
            // only query api if the pub has no coordinates
            //if (!$pub->geo) {
                $pub->placesApiSearch();
                // sleep for 0.999999 seconds
                usleep(999999);
            //}
        }

        $bar->finish();

        $this->info(PHP_EOL.'Done.');
    }
}
