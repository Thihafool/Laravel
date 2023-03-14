@extends('master')

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-6 offset-4">
                <div class="my-3">
                    <a href="{{ route('post#home') }}" class="text-decoration-none text-black"><i
                            class="fa-solid fa-left-long"></i>back</a>
                </div>
                <h3>{{ $post->title }}</h3>
                <div class="d-flex">
                    <div class="btn btn-sm bg-dark text-white me-2 my-3"><i class="fa-solid fa-money-bill-1 text-primary"></i>{{ $post->price }} kyats</div>
                    <div class="btn btn-sm bg-dark text-white me-2 my-3"><i class="fa-solid fa-location-dot text-danger"></i>{{ $post->address }}</div>
                    <div class="btn btn-sm bg-dark text-white me-2 my-3"><i class="fa-solid fa-star text-warning text-warning"></i>{{ $post->rating }}</div>
                    <div class="btn btn-sm bg-dark text-white me-2 my-3">{{ $post->created_at->format('j-F-Y') }}</div>
                    <div class="btn btn-sm bg-dark text-white me-2 my-3">{{ $post->created_at->format('h:m:s:A') }}</div>
                </div>
                <div class="">
                    @if ($post->image == null)
                        <img class="img-thumbnail shadow-sm" src="{{asset('error404.png')}}" >

                    @else
                    <img class="img-thumbnail shadow-sm" src="{{asset('storage/'.$post->image)}}" >
                    @endif


                </div>
                <p>{{ $post->description }}</p>
            </div>
        </div>
        <div class="row m-3">
            <div class="col-3 offset-9 ">
                <a href="{{ route('edit#page', $post['id']) }}"> <button class="btn btn-dark text-white">Edit</button>
                </a>
            </div>
        </div>
    </div>
@endsection
