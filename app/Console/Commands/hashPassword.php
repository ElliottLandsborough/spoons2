<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

use Hash;

class hashPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hashPassword';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hash a password';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $password = $this->secret('What is the password?');
        echo Hash::make($password) . PHP_EOL . PHP_EOL;
    }
}
