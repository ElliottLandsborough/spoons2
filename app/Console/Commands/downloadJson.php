<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

use App\Pub;
use File;

class downloadJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'downloadJson';

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
        Pub::getSpoonsJson();
    }
}
