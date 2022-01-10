<?php

namespace App\Http\Controllers\Screencast;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\PlaylistRequest;
use App\Http\Resources\Screencast\PlaylistResource;
use App\Models\Screencast\Playlist;
use App\Models\Screencast\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PlaylistController extends Controller
{
    public function index()
    {
        $playlist = Playlist::with('user')
                            ->latest()
                            ->paginate(9);
        return PlaylistResource::collection($playlist);
    }

    public function show(Playlist $playlist)
    {
        return new PlaylistResource($playlist);
    }

    public function create()
    {
        return view('playlists.create', [
            'playlist' => new Playlist(),
            'tags' => Tag::get(),
        ]);
    }

    public function store(PlaylistRequest $request)
    {
        $playlist = Auth::user()->playlists()->create([
            'name' => $request->name,
            'thumbnail' => $request->file('thumbnail')->store('images/playlist'),
            'slug' => Str::slug($request->name . '-' . Str::random(6)),
            'description' => $request->description,
            'price' => $request->price,
        ]);

        $playlist->tags()->sync(request('tags'));

        return back();
    }

    public function table()
    {
        $playlists = Auth::user()->playlists()->latest()->paginate(10);
        return view('playlists.table', compact('playlists'));
    }

    public function edit(Playlist $playlist)
    {
        $this->authorize('update', $playlist);
        return view('playlists.edit', [
            'playlist' => $playlist,
            'tags' => Tag::get(),
        ]);
    }

    public function update(PlaylistRequest $request, Playlist $playlist)
    {
        $this->authorize('update', $playlist);
        if($request->thumbnail){
            Storage::delete($playlist->thumbnail);
            $thumbnail = $request->file('thumbnail')->store('images/playlist');
        }else {
            $thumbnail = $playlist->thumbnail;
        }
        $playlist->update([
            'name' => $request->name,
            'thumbnail' => $thumbnail,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        $playlist->tags()->sync(request('tags'));

        return redirect(route('playlists.table'));
    }

    public function destroy(Playlist $playlist)
    {
        $this->authorize('delete', $playlist);
        Storage::delete($playlist->thumbnail);
        $playlist->tags()->detach();
        $playlist->delete();

        return redirect(route('playlists.table'));
    }
}
