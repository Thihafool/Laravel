@extends('master')

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-6 offset-4">
                <div class="my-3">
                    <a href="{{ route('post#updatepage', $post['id']) }}" class="text-decoration-none text-black"><i
                            class="fa-solid fa-left-long"></i>back</a>
                </div>
                {{-- <h3>{{ $post['title'] }}</h3>
                <p>{{ $post['description'] }}</p> --}}
                <form action="{{ route('post#update', $post['id']) }}" method="post">
                    @csrf
                    <label for="">Post Title</label>
                    <input type="hidden" name="postId" value="{{ $post['id'] }}">
                    <input type="text" name="postTitle" id=""
                        class="form-control my-3 @error('postTitle')
                        is-invalid
                    @enderror"
                        placeholder="Enter post title" value="{{ old('postTitle', $post['title']) }}">
                    @error('postTitle')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <label for="">Post Description</label>
                    <textarea name="postDescription" id="" cols="30" rows="10" class="form-control my-3 "
                        placeholder="Enter post description"> {{ old('postDescription', $post['description']) }}</textarea>
                    <input type="submit" value="Update"
                        class="btn bg-dark text-white float-end @error('postDescription')
                        is-invalid
                    @enderror">
                    @error('postDescription')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </form>
            </div>
        </div>
    </div>
@endsection
