<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;

class BanInactiveDriver extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'driver:ban';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ban Inactive drivers';

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
        $day = Carbon::yesterday()->format('l');
        $addedHours = (strtolower($day) == 'saturday') ? 36 + 24 : 36;

        $providers = DB::table('providers')
                        // ->select('first_name', 'payable')
                        ->where('payable', '>','0')
                        ->where('updated_at', '<', Carbon::now()->subHours($addedHours))
                        ->update(['status' => 'banned'], ['timestamps' => false]);
                        // ->get()->toArray();
        \Log::info("Ban Drivers with inactivity hours - $addedHours " .print_r($providers, true));
    }
}
