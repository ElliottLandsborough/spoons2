<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

use Config;
use App\Geo;

class sendGeoToElasticSearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendGeoToElasticSearch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send coordinates to elastic search';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $elasticaClient = new \Elastica\Client(array('url'=>Config::get('spoons.searchlyUrl')));
        // Load index
        $elasticaIndex = $elasticaClient->getIndex('pubs');
        if (!$elasticaIndex->exists()) {
            // Create index
            $elasticaIndex->create();
        } else {
            // Delete and then create
            $elasticaIndex->delete();
            $elasticaIndex->create();
        }
        // Get type
        $elasticaType = $elasticaIndex->getType('pub');
        $geos = Geo::get();
        $this->info('Building coordinates array...');
        $bar = $this->output->createProgressBar(count($geos));
        $documents = array();
        foreach ($geos as $geo) { 
            $documents[] = new \Elastica\Document($geo->id,$geo);
            $bar->advance();
        }
        $bar->finish();
        $this->info(PHP_EOL.'Sending array to ES...');
        $elasticaType->addDocuments($documents);
        $this->info('Done.');
    }
}