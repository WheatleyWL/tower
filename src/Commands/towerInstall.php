<?php

namespace zedsh\tower\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class towerInstall extends Command
{
    public $signature = 'tower:install';

    public $description = 'Command for first expand tower in your Laravel project';


    public function __construct() {
        parent::__construct();
    }

    public function handle()
    {
        // Install ProjectTemplate into your Laravel project
        (new Filesystem)->copyDirectory(__DIR__.'/assets/expand/ProjectTemplate', app_path());
        // Install AdminResourceController into your project
        (new Filesystem)->copyDirectory(__DIR__.'/assets/expand/AdminResourceController', app_path().'/Http/Controllers/');
        // Copy assets into your project
        (new Filesystem)->copyDirectory(__DIR__.'/../../assets/admin_assets', public_path('admin_assets'));
    }

}
