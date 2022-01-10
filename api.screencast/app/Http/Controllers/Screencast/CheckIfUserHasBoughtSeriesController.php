<?php

namespace App\Http\Controllers\Screencast;

use App\Http\Controllers\Controller;
use App\Models\Screencast\Playlist;
use Illuminate\Http\Request;

class CheckIfUserHasBoughtSeriesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Playlist $playlist)
    {
        return response()->json([
            'data' => $request->user()->hasBought($playlist)
        ]);
    }
}
