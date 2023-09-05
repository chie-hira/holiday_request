<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class LogsClean extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old log files';

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
     * @return int
     */
    public function handle()
    {
        $logsPath = storage_path('logs');
        $files = File::files($logsPath);

        $thresholdDate = now()->subDays(14); // 14日以上前のログを削除

        foreach ($files as $file) {
            $fileDate = File::lastModified($file);
            if ($fileDate < $thresholdDate->timestamp) {
                File::delete($file);
                $this->info('Deleted log: ' . $file);
            }
        }
    }
}
