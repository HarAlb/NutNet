<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTrackPost;
use App\testHelper\Helper;
use App\Track;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\UpdateTrack;
use PHPUnit\TextUI\Help;

class TracksController extends Controller
{

    public function __construct()
    {
        $this->middleware('check.slug')->only(['show' , 'edit' , 'update']);

        $this->middleware('auth')->except(['show' , 'index']);

        $this->middleware('check.author')->only('edit' , 'update' , 'destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tracks = Cache::has('tracks') ? Cache::get('tracks') : Helper::get_tracks_db();

        return view('home')->with(compact('tracks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tracks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrackPost $req)
    {
        $songName = $this->generate_name_file($req->file('song'));
        $thumbName = $this->generate_name_file($req->file('thumb'));
        $u_id = $req->user()->id;
        $req->file('song')->move(public_path("uploads/$u_id/songs"), $songName );
        $req->file('thumb')->move(public_path("uploads/$u_id/thumbs"), $thumbName);

        $slug = str_slug( strip_tags( trim( $req->title )) , '-' );

        if( Track::where('slug' , $slug )->first() ){
            $slug.= "-". Track::latest('id')->first() ? ++Track::latest('id')->first()->id : 1 ;
        }

        Track::create([
            'title' => strip_tags( trim($req->title)),
            'description' => strip_tags(trim($req->description)),
            'slug' => $slug,
            'file_path' => url("uploads/$u_id/songs/". $songName),
            'thumb' => url("uploads/$u_id/thumbs/" . $thumbName),
            'u_id' => $u_id
        ]);

        Helper::addTrackToCache();

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $with_related = Helper::get_by_slug($slug);
        $sing = $with_related['track'];
        $rels = $with_related['related'];
        return view('tracks.show')->with(compact('sing' , 'rels'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $track = Helper::get_by_slug($slug)['track'];

        return view('tracks.edit')->with(compact('track'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTrack $request, $slug)
    {
        $u_id = $request->user()->id;
        $to_update = [];

        if( $request->file('song') ){
            $songName = $this->generate_name_file($request->file('song'));
            $request->file('song')->move(public_path("uploads/$u_id/songs"), $songName);
            $to_update['file_path'] = url("uploads/$u_id/songs/". $songName);
        }

        if( $request->file('thumb') ){
            $thumbName = $this->generate_name_file($request->file('thumb'));
            $request->file('thumb')->move(public_path("uploads/$u_id/thumbs"), $thumbName);
            $to_update['thumb'] = url("uploads/$u_id/thumbs/" . $thumbName);
        }

        $to_update['title']  = strip_tags( trim($request->title) );
        $to_update['description'] = strip_tags( trim($request->description) );




        $updated_track = Track::where('slug' , $slug )->update($to_update);
        $to_update['id'] = $updated_track;

        Helper::deleteTrackCache();

        return redirect()->route('tracks.show' , $slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {

        Track::where('slug' , $slug)->delete();

        Helper::deleteTrackCache();

        return redirect()->route('home');
    }

    private function generate_name_file( $file ){
        $nameExploded = explode('.' , $file->getClientOriginalName());
        return Str::random(20) .'.' . $nameExploded[count($nameExploded) - 1 ];
    }
}
