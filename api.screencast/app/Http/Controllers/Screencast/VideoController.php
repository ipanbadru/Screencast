<?php

namespace App\Http\Controllers\Screencast;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Screencast\Video;
use App\Http\Requests\VideoRequest;
use App\Models\Screencast\Playlist;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Screencast\VideoResource;

class VideoController extends Controller
{
    public function index(Playlist $playlist)
    {
        $videos = $playlist->videos()->orderBy('episode')->get();
        return (VideoResource::collection($videos))->additional(compact('playlist'));
    }

    public function show(PLaylist $playlist, Video $video)
    {
        if(Auth::user()->hasBought($playlist) || $video->intro == 1){
            return (new VideoResource($video))->additional(compact('playlist'));
        }

        return response()->json(['message' => 'You have to buy before watching!'], 401);
    }

    public function table(Playlist $playlist)
    {
        $this->authorize('update', $playlist);

        return view('videos.table', [
            'title' => "Table of {$playlist->name} content",
            'playlist' => $playlist,
            'videos' => $playlist->videos()->orderBy('episode')->paginate(20)
        ]);
    }

    public function create(Playlist $playlist)
    {
        $this->authorize('update', $playlist);
        return view('videos.create', [
            'playlist' => $playlist,
            'title' => "New Video : {$playlist->name}",
            'video' => new Video
        ]);
    }

    public function store(Playlist $playlist, VideoRequest $request)
    {
        $this->authorize('update', $playlist);
        $attr = $request->all();
        $attr['slug'] = Str::slug($request->title . '-' . Str::random(6));
        $attr['intro'] = $request->intro ? true : false;
        $playlist->videos()->create($attr);

        return back();
    }

    public function edit(Playlist $playlist, Video $video)
    {
        $this->authorize('update', $playlist);
        return view('videos.edit', [
            'playlist' => $playlist,
            'title' => "Edit Video : {$playlist->name} - {$video->title}",
            'video' => $video
        ]);
    }

    public function update(Playlist $playlist, Video $video, VideoRequest $request)
    {
        $this->authorize('update', $playlist);
        $attr = $request->all();

        $attr['intro'] = $request->intro ? true : false;
        $video->update($attr);

        return redirect(route('videos.table', $playlist->slug));
    }

    public function destroy(Playlist $playlist, Video $video)
    {
        $this->authorize('update', $playlist);
        $video->delete();
        return redirect(route('videos.table', $playlist->slug));
    }
}
