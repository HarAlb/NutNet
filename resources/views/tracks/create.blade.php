@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <form method="post" action="{{ route('tracks.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                @if($errors->has('title'))
                    <label for="trackTitle" class="text-danger"> {{ $errors->first('title') }} </label>
                @else
                    <label for="trackTitle"> Track Title </label>
                @endif
                <input type="text" class="form-control  @error('title') is-invalid @enderror" id="trackTitle" name="title" placeholder="Enter Title" value="{{ old('title') }}" required maxlength="250">
            </div>
            <div class="form-group">
                @if($errors->has('description'))
                    <label for="trackDesc" class="text-danger">{{ $errors->first('description') }} </label>
                @else
                    <label for="trackDesc">Track Description</label>
                @endif
                <textarea class="form-control  @error('description') is-invalid @enderror" id="trackDesc" name="description" placeholder="Enter Description" required maxlength="350"></textarea>
            </div>
            <div class="form-group">
                @if($errors->has('thumb'))
                    <label for="trackThumb" class="text-danger">{{$errors->first('thumb')}}</label>
                @else
                    <label for="trackThumb">Thumbnail Track</label>
                @endif
                <input type="file" class="form-control-file  @error('thumb') is-invalid @enderror" id="trackThumb" name="thumb" required>
            </div>
            <div class="form-group">
                @if($errors->has('song'))
                    <label for="trackSong" class="text-danger">{{ $errors->first('song') }}</label>
                @else
                    <label for="trackSong">Track Title</label>
                @endif
                <input type="file" class="form-control-file  @error('song') is-invalid @enderror" id="trackSong" name="song" placeholder="Enter Music Here" required>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Creat Track" />
            </div>
        </form>
    </div>
</div>
@endsection
