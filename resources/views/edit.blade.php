@extends('master')

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-6 offset-4">
                <div class="my-3">
                    <a href="{{ route('post#updatepage', $post['id']) }}" class="text-decoration-none text-black"><i
                            class="fa-solid fa-left-long"></i>back</a>
                </div>

                <form action="{{ route('post#update', $post['id']) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <label for="">Post Title</label>
                    <input type="hidden" name="postId" value="{{ $post['id'] }}">
                    <input type="text" name="postTitle" id=""
                        class="form-control my-3 @error('postTitle')
                        is-invalid @enderror" placeholder="Enter post title" value="{{ old('postTitle', $post['title']) }}">
                    @error('postTitle')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <label for="">Post Image</label>

                    <div class="my-3 ">
                        @if ($post['image'] == null)
                            <img class="img-thumbnail shadow-sm " src="{{asset('error404.png')}}" >

                        @else
                        <img class="img-thumbnail shadow-sm " src="{{asset('storage/'.$post['image'])}}" >
                        @endif
                        <input type="file" class="form-control @error('postImage')is-invalid @enderror"
                                name="postImage" value="{{ old('postImage') }}">
                            @error('postImage')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                    </div>
                    <label for="">Post Description</label>
                    <textarea name="postDescription" id="" cols="30" rows="10" class="form-control my-3 @error('postDescription')
                    is-invalid @enderror" placeholder="Enter post description"> {{ old('postDescription', $post['description']) }}</textarea>
                    @error('postDescription')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror


                    <label for="">Post Fee</label>
                    <input type="text" name="postFees" value="{{old ('postFees',$post['price'])}}"  class="form-control my-3">

                    <label for="">Post Address</label>
                    <input type="text"name="postAddress" value="{{old ('postAddress',$post['address'])}}"  class="form-control my-3">

                    <label for="">Post Rating</label>
                    <input type="text"name="postRating" value="{{old ('postRating',$post['rating'])}}"  class="form-control my-3">

                    <input type="submit" value="Update" class="btn bg-dark text-white float-end my-3 ">
                </form>
            </div>
        </div>
    </div>
@endsection
