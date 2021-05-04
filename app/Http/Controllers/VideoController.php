<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoRequest;
use App\Jobs\CompetitionResult;
use App\Models\Competition;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;


class VideoController extends Controller
{

    public function create()
    {
        return view('videos.create');
    }

    public function store(VideoRequest $request) : RedirectResponse
    {


        $userVideo = Video::where('user_id',auth()->id())
            ->where('competition',0)
            ->count();
        if (!$userVideo)
        {
            if($file = $request->file('video')){

                $video_name = Carbon::now()->format('Y-m-d').'_video_'.$file->getClientOriginalName();
                $file->move('videosFiles',$video_name);
            }
            $videoData = [
                'name' => $request->name,
                'video_path' =>$video_name,
                'user_id' => auth()->id(),
            ];
            $competitionVideosCount = Video::where('competition',0)->count();
            if ($competitionVideosCount == 3)
            {
                $competition = Competition::create([
                    'status'=>0
                 ]);

                // Dispatch A CompetitionResult Job
                CompetitionResult::dispatch($competition->id)->delay(now()->addHours(1));

                Video::create($videoData);
                $competitionVideos = Video::where('competition',0)->pluck('id');
                $competition->videos()->attach($competitionVideos);
                Video::where('competition',0)->update([
                    'competition'=>1
                ]);


            }else{
                Video::create($videoData);

            }
            $returnMsg = ['msg'=>'Your Video Upload Successfully'];

        }else{
            $returnMsg = ['msg'=>'You Cannot Upload A Video Because One Video Already In Queue For Competition'];

        }

        return redirect()->route('allCompetition')->with($returnMsg);

    }

}
