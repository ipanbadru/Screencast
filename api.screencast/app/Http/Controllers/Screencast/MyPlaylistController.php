<?php

namespace App\Http\Controllers\Screencast;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Screencast\PlaylistResource;

class MyPlaylistController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $playlists = Auth::user()->purchases()->latest()->paginate(10);
        return PlaylistResource::collection($playlists);
    }
}
