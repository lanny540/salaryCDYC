<?php

namespace App\Console\Commands;

use App\Services\SyncService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Log;

class subject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subject:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '从远程数据库中同步会计科目至本地';

    protected $sync;

    /**
     * Create a new command instance.
     *
     * @param SyncService $syncService
     */
    public function __construct(SyncService $syncService)
    {
        parent::__construct();
        $this->sync = $syncService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $r = $this->sync->syncSubjectFromOracle();
        if (!$r) {
            Log::channel('syncsubject')->info(Carbon::now().' 会计科目同步失败');
        } else {
            Log::channel('syncsubject')->info(Carbon::now().' 会计科目同步成功');
        }

    }
}
