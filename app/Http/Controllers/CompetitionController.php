<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    public function index()
    {

        $competitons = Competition::orderBy('id','DESC')->get();
        return view('competitions.index',compact('competitons'));
    }

    public function competitionVideos($id)
    {
        $competitionVideos = Competition::whereHas('userVideos')
            ->with('userVideos')
            ->findOrFail($id);
        return view('competitions.competition-videos',compact('competitionVideos'));

    }



}
