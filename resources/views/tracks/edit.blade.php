@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <form method="post" action="{{ route('tracks.update' , $track['slug']) }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="form-group">
                @if($errors->has('title'))
                    <label for="trackTitle" class="text-danger"> {{ $errors->first('title') }} </label>
                @else
                    <label for="trackTitle"> Track Title </label>
                @endif
                <input type="text" class="form-control  @error('title') is-invalid @enderror" id="trackTitle" name="title" placeholder="Enter Title" value="{{ old('title') ? old('title') : $track['title']  }}" required maxlength="250">
            </div>
            <div class="form-group">
                @if($errors->has('description'))
                    <label for="trackDesc" class="text-danger">{{ $errors->first('description') }} </label>
                @else
                    <label for="trackDesc">Track Description</label>
                @endif
                <textarea class="form-control  @error('description') is-invalid @enderror" id="trackDesc" name="description" data-value="{{ old('description') ? old('description') : $track['description']  }}" placeholder="Enter Description" required maxlength="350"></textarea>
            </div>
            <div class="form-group row">
                <div class="col">
                    @if($errors->has('thumb'))
                        <label for="trackThumb" class="text-danger">{{$errors->first('thumb')}}</label>
                    @else
                        <label for="trackThumb">Thumbnail Track</label>
                    @endif
                    <input type="file" class="form-control-file  @error('thumb') is-invalid @enderror" id="trackThumb" name="thumb">
                </div>
                <div class="col">
                    <img src="{{$track['thumb']}}" alt="laravel Image" style="width:120px; height:120px;"/>
                </div>
            </div>
            <div class="form-group row">
                <div class="col">
                    @if($errors->has('song'))
                    <label for="trackSong" class="text-danger">{{ $errors->first('song') }}</label>
                @else
                    <label for="trackSong">Track Title</label>
                @endif
                <input type="file" class="form-control-file  @error('song') is-invalid @enderror" id="trackSong" name="song" placeholder="Enter Music Here">
                </div>
                <div class="col">
                    <audio controls>
                        <source src="{{$track['song']}}" type="audio/mpeg">
                    </audio>
                </div>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Update Track" />
            </div>
        </form>

    </div>
    <div class="row">
        <form id="deleteForm" method="post" action="{{ route('tracks.destroy' , $track['slug']) }}">
            @csrf
            <input type="hidden" name="_method" value="DELETE">
            <div class="form-group">
                <input type="submit" value="delete" name="delete" class="btn btn-danger"/>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script type="text/javascript">

        document.addEventListener("DOMContentLoaded", ready);




        function ready(){
            var forDesc = document.querySelector("textarea[data-value]");
            forDesc.innerHTML = forDesc.attributes["data-value"]["value"];

            var inputDelete = document.querySelector("input[name='delete']");
            inputDelete.onclick = function (){
                if (confirm('Do you want to Delete track?')) {
                    document.getElementById('deleteForm').submit();
                } else {
                    return false;
                }
            }
        }
    </script>
@endsection
