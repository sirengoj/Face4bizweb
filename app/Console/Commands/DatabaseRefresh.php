<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Madnest\Madzipper\Facades\Madzipper;

class DatabaseRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh database after a certain time';

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
        Artisan::call('migrate:reset');
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('currencies');
        Schema::dropIfExists('flash_deal_products');
        Schema::dropIfExists('help_topics');
        Schema::dropIfExists('migrations');

        $sql_path = base_path('installation/database.sql');
        DB::unprepared(file_get_contents($sql_path));
        File::deleteDirectory('storage/app/public');
        Storage::disk('public')->makeDirectory('');
        Madzipper::make('installation/public.zip')->extractTo('storage/app/public');
    }
}
