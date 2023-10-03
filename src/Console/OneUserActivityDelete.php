<?php

namespace Haruncpi\LaravelUserActivity\Console;

use Haruncpi\LaravelUserActivity\Models\Log;
use Illuminate\Console\Command;

class OneUserActivityDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'one-user-activity:delete {user_id} {delete_limit?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will delete only one user log activity data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $user_id = $this->argument('user_id');
        $deleteLimit = $this->argument('delete_limit');
        switch (strtolower(trim($deleteLimit))) {
            case 'all':
                Log::where('user_id',$user_id)->delete();
                $this->info("All log data deleted for User_id $user_id!");
                break;
            default:
                if (is_numeric($deleteLimit)) {
                    Log::where('user_id',$user_id)->whereRaw('log_date < NOW() - INTERVAL ? DAY', [$deleteLimit])->delete();
                    $this->info("Successfully deleted log data for User_id $user_id,  older than $deleteLimit days");
                } else {
                    $dayLimit = config('user-activity.delete_limit');
                    Log::where('user_id',$user_id)->whereRaw('log_date < NOW() - INTERVAL ? DAY', [$dayLimit])->delete();
                    $this->info("Successfully deleted log data for User_id $user_id , older than $dayLimit days");
                }
        }

    }


}
