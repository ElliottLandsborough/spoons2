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
        // set mapping
        $mapping = new \Elastica\Type\Mapping();
        $mapping->setType($elasticaType);
        //$mapping->setParam('index_analyzer', 'indexAnalyzer');
        //$mapping->setParam('search_analyzer', 'searchAnalyzer');
        $mapping->setProperties(array(
            'id'      => array('type' => 'integer', 'include_in_all' => TRUE),
            'pub_id'      => array('type' => 'integer', 'include_in_all' => TRUE),
            'location'=> array('type' => 'geo_point', 'include_in_all' => TRUE),
        ));
        // Send mapping to type
        $mapping->send();
        // get all geos and index
        $geos = Geo::get();
        $this->info('Building coordinates array...');
        $bar = $this->output->createProgressBar(count($geos));
        $documents = array();
        foreach ($geos as $geo) { 
            $item = array(
                'pub_id' => $geo->pub_id,
                'location' => array(
                    'lat' => $geo->lat,
                    'lon' => $geo->lon
                )
            );
            $documents[] = new \Elastica\Document($geo->id, $item);
            $bar->advance();
        }
        $bar->finish();
        $this->info(PHP_EOL.'Sending array to ES...');
        $elasticaType->addDocuments($documents);
        $this->info('Done.');
    }
}