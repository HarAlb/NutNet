<?php

namespace App\testHelper;


use Illuminate\Support\Facades\Cache;
use App\Jobs\ProcessTracksCache;
use App\Track;
use Illuminate\Support\Facades\Artisan;
use Prophecy\Call\Call;

class Helper
{
    public static function cache_tracks()
    {
        ProcessTracksCache::dispatchAfterResponse();
    }

    public static function clearCache(string $cacheKey)
    {
        if (Cache::has($cacheKey)) {

            Cache::forget($cacheKey);
        }
    }

    public static function addTrackToCache()
    {
        if (Cache::has('tracks')) {
            $tracks = Cache::get('tracks');
            $caches = collect($tracks);
            $newest = Track::where('id', '>', $caches->last()['id'] ? $caches->last()['id'] : 0 )->get();
            if ($newest) {
                $newest->each(function ($item, $key) use (&$tracks) {
                    $tracks[] = [
                        'id'  => $item->id,
                        'title' => $item->title,
                        'thumb' => $item->thumb,
                        'song'  => $item->file_path,
                        'slug'   => $item->slug,
                        'author_name' => $item->authorName(),
                        'author_email' => $item->authorEmail(),
                        'date' => $item->created_at->toDateTimeString(),
                        'u_id' => $item->u_id,
                        'description' => $item->description
                    ];
                });
                Cache::put('tracks' , $tracks);
            }
        }
    }

    public static function get_tracks_db()
    {
        $allTracks = Track::all();

        $tracks = [];

        $allTracks->each(function ($item, $key) use (&$tracks) {
            $tracks[] = [
                'id'  => $item->id,
                'title' => $item->title,
                'thumb' => $item->thumb,
                'song'  => $item->file_path,
                'slug'   => $item->slug,
                'author_name' => $item->authorName(),
                'author_email' => $item->authorEmail(),
                'date' => $item->created_at->toDateTimeString(),
                'u_id' => $item->u_id,
                'description' => $item->description
            ];
        });

        return $tracks;
    }

    public static function get_by_slug( $slug )
    {
        if(Cache::has('tracks')){
            $tracks = Cache::get('tracks');
            $all = collect($tracks);
            if( $all->where('slug' , trim($slug) ) ){
                return [ 'track' => $all->where('slug' , trim($slug))->first() , 'related' =>  $all->where('slug' , '!=' , trim($slug))->all() ];
            }
        }

        $track = Track::where('slug' , trim($slug))->first();
        $track_array = [
            'id'  => $track->id,
            'title' => $track->title,
            'thumb' => $track->thumb,
            'song'  => $track->file_path,
            'slug'   => $track->slug,
            'author_name' => $track->authorName(),
            'author_email' => $track->authorEmail(),
            'date' => $track->created_at->toDateTimeString(),
            'u_id' => $track->u_id,
            'description' => $track->description
        ];
        $related = Track::where('slug' , '!=' , trim($slug))->take(5);
        $rel = [];
        $related->each(function ($item , $key ) use (&$rel){
            $rel[] = [
                'id'  => $item->id,
                'title' => $item->title,
                'thumb' => $item->thumb,
                'song'  => $item->file_path,
                'slug'   => $item->slug,
                'author_name' => $item->authorName(),
                'author_email' => $item->authorEmail(),
                'date' => $item->created_at->toDateTimeString(),
                'u_id' => $item->u_id,
                'description' => $item->description
            ];
        });
        return ['track' => $track_array , 'related' => $rel];

    }

    public static function deleteTrackCache()
    {
        if(Cache::has('tracks')){
            Cache::forget('tracks');
        }
    }

}
