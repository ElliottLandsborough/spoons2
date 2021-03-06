<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

use App\Pub;
use File;

class jsonToDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jsonToDb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse the spoons json into the database';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($file = Pub::getLatestJsonFileName()) {
            if ($json = File::get($file)) {
                Pub::jsonToDb($json, true);
            }
        }
    }
}
