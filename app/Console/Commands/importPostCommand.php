<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class importPostCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Posts';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        importPosts();
        $this->info(trans('messages.success_import'));
    }
}
