@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <img src="{{$sing['thumb']}}" alt="Single Thumb" class="mw-100 rounded d-block"/>
        <h1>{{ $sing['title'] }}</h1>
        <audio controls>
            <source src="{{$sing['song']}}" type="audio/mpeg">
        </audio>
        </div>
        <div class="row">
            <h2>Related Posts</h2>
        </div>
        <div class="row">

            @foreach($rels as $rel)
            <div class="col-3">
                <a href="{{url('/tracks/'.$rel['slug'])}}" class="d-block" >
                    <img src="{{$rel['thumb']}}" alt="Laravel Image Thumb" class="img-rounded mw-100 mh-100"/>
                    <div>
                        <h3>{{$rel['title']}}</h3>
                        <audio controls>
                            <source src="{{$rel['song']}}" type="audio/mpeg">
                            </audio>
                        </div>
                        <div>
                            <a href="mailto: {{ $rel['author_email']}}"><span>{{ $rel['author_name'] }}</span></a>
                            <span>{{ $rel['date'] }}</span>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
@endsection
