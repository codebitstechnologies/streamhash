<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OriginalVideoCompression extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $getPathname;
    protected $inputFile;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($getPathname, $inputFile)
    {
        $this->getPathname = $getPathname;
        $this->inputFile = $inputFile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Compress the video and save in original folder
        $FFmpeg = new \FFmpeg;

        $FFmpeg
            ->input($this->getPathname)
            ->vcodec('h264')
            ->constantRateFactor('28')
            ->output($this->inputFile)
            ->ready();
    }
}
