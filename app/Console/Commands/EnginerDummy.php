<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Enginer;

class EnginerDummy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dummy:enginer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dummy Enginer';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Enginer::create([
            'name' => 'enginer 1',
            'email' => 'enginer1@gmail.com'
        ]);
        Enginer::create([
            'name' => 'enginer 2',
            'email' => 'enginer2@gmail.com'
        ]);
        Enginer::create([
            'name' => 'enginer 3',
            'email' => 'enginer3@gmail.com'
        ]);
    }
}
