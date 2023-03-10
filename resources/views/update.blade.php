@extends('master')

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-6 offset-4">
                <div class="my-3">
                    <a href="{{ route('post#home') }}" class="text-decoration-none text-black"><i
                            class="fa-solid fa-left-long"></i>back</a>
                </div>
                <h3>{{ $post[0]->title }}</h3>
                <p>{{ $post[0]->description }}</p>
            </div>
        </div>
        <div class="row m-3">
            <div class="col-3 offset-9 ">
                <a href="{{ route('edit#page', $post[0]['id']) }}"> <button class="btn btn-dark text-white">Edit</button>
                </a>
            </div>
        </div>
    </div>
@endsection
