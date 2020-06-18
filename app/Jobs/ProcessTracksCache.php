<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\testHelper\Helper;
use Illuminate\Support\Facades\Cache;

class ProcessTracksCache implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(  )
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Cache::put('tracks' , Helper::get_tracks_db());
    }
}
