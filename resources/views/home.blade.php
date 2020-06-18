@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if(!empty($tracks))
            @foreach($tracks as $track)
                <div class="col-3">
                    <a href="{{url('/tracks/'.$track['slug'])}}" class="" style="display:block;">
                        <img src="{{$track['thumb']}}" alt="Laravel Image Thumb" class="img-rounded mw-100 mh-100"/>
                        <div>
                            <h3>{{$track['title']}}</h3>
                            <audio controls>
                                <source src="{{$track['song']}}" type="audio/mpeg">
                            </audio>
                        </div>
                        <div>
                            <a href="mailto: {{ $track['author_email']}}"><span>{{ $track['author_name'] }}</span></a>
                            <span>{{ $track['date'] }}</span>
                        </div>
                    </a>
                </div>

            @endforeach
        @else
            <h2>Nothing To Show , <a href="{{ route('tracks.create') }}" class="btn btn-danger"/>Be First</a></h2>
        @endif
    </div>
</div>
@endsection
