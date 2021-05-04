<?php

namespace App\Jobs;

use App\Models\Competition;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CompetitionResult implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @Assig a Competition ID @param  competition_id
     */

    public $competition_id = null;
    public function __construct($competition_id)
    {
        //

        $this->competition_id = $competition_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $competitionVideos = Competition::with('videos')
            ->where('id',$this->competition_id)
            ->get()
            ->pluck('videos')
            ->collapse()
            ->pluck('id')
            ->toArray();


        $rating =  DB::table('ratings')
            ->whereIn('video_id',$competitionVideos)
            ->select(DB::raw('video_id'), DB::raw('sum(rating) as rating'))
            ->groupBy(DB::raw('video_id') )
            ->orderBy('rating','DESC')
            ->first();

        $competitionUpdateData = [
            'status' => 1
        ];

        /**
         * Check Any Rating Given to any video of competition
         *  if yes than update highest rating video id into Competition Table
         *  otherwise first video id update into Competition Table
         */
        $rating ? $competitionUpdateData['video_id'] =$rating->video_id : $competitionUpdateData['video_id'] = $competitionVideos[0];

        Competition::where('id',$this->competition_id)
            ->update($competitionUpdateData);

    }
}
