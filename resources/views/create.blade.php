@extends('master')
@section('content')
    {{-- <h2 class="text-danger"> <i class="fa fa-user "></i>Hello world </h2> --}}
    <div class="container">
        <div class="row mt-5">
            <div class="col-5 ">
                <div class="p-3">
                    @if (session('insertSuccess'))
                        <div class="alert-message">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ session('insertSuccess') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    @if (session('updateSuccess'))
                        <div class="alert-message">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ session('updateSuccess') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    {{-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}
                    <form action="{{ route('post#create') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="text-group mb-2">
                            <label for="">Post Title</label>
                            <input type="text" class="form-control mt-3 @error('postTitle')is-invalid @enderror"
                                name="postTitle" value="{{ old('postTitle') }}" placeholder="Enter Post Title">

                            @error('postTitle')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="text-group mb-2">
                            <label for="">Post Description</label>
                            <textarea type="text" class="form-control mt-3  @error('postDescription')is-invalid @enderror " cols="25"
                                rows="8" name="postDescription" placeholder="Enter Post Description">{{ old('postDescription') }}</textarea>
                            @error('postDescription')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="text-group mb-2">
                            <label for="">Image</label>
                            <input type="file" class="form-control mt-3 @error('postImage')is-invalid @enderror"
                                name="postImage" value="{{ old('postImage') }}">
                            @error('postImage')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>
                        <div class="text-group mb-2">
                            <label for="">Fees</label>
                            <input type="number" class="form-control mt-3 @error('postFees')is-invalid @enderror"
                                name="postFees" value="{{ old('postFees') }}" placeholder="Enter Post fee">
                            @error('postFees')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="text-group mb-2">
                            <label for="">Address</label>
                            <input type="text" class="form-control mt-3 @error('postAddress')is-invalid @enderror"
                                name="postAddress" value="{{ old('postAddress') }}" placeholder="Enter Post address">
                            @error('postAddress')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="text-group mb-2">
                            <label for="">Rating</label>
                            <input type="number" min="0" max="5"
                                class="form-control mt-3 @error('postRating')is-invalid @enderror" name="postRating"
                                value="{{ old('postRating') }}">
                            @error('postRating')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <input type="submit" value="Create" class="btn btn-primary ">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-7 ">
                <h3 class="mb-3">
                    <div class="row">
                        <div class="col-5">Total - {{ $posts->total() }}</div>
                        <div class="col-7 ">
                            <form action="{{ route('post#createPage') }}" method="get">
                                <div class="row">
                                    <input type="text" name="searchKey" value="{{ request('searchKey') }}"
                                        id="" class="form-control col" placeholder="Enter search Key">
                                    <button class="btn btn-outline-primary col-2" type="submit">Search<i
                                            class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </h3>
                <div class="data-container">
                    @if (count($posts) != 0)
                        @foreach ($posts as $items)
                            <div class="post p-3 shadow-sm mb-3">
                                <div class="row d-flex">
                                    <h5 class="col-7">{{ $items->title }}</h5>
                                    <h6 class="col-5 float-end">
                                        <div>{{ $items->created_at->format('j-F-Y') }}</div>

                                    </h6>


                                    {{-- <span class="col-4">{{ $items['created_at']->format('d M Y') }}</span> --}}
                                </div>
                                {{-- <p class="text-muted">{{ substr($items['description'], 0, 100) }}</p> --}}
                                <p class="text-muted">{{ Str::words($items->description, 25, '.....') }}</p>
                                <span><small><i
                                            class="fa-solid fa-money-bill-1 text-primary"></i>{{ $items->price }}</small></span>
                                |
                                <span><small>{{ $items->address }} <i
                                            class="fa-solid fa-location-dot text-danger"></i></small></span> |
                                <span>{{ $items->rating }} <i class="fa-solid fa-star text-warning"></i></span>
                                <div class="float-end d-flex">
                                    {{-- <a href="{{ url('post/delete/' . $items['id']) }}">
                                <a href="{{ route('post#delete', $items['id']) }}">
                                    <button class="btn btn-sm btn-danger"><i
                                            class="fa-sharp fa-solid fa-trash">ဖျက်ရန်</i></button>
                                </a> --}}

                                    <form action="{{ route('post#delete', $items->id) }} " method="get">
                                        @csrf
                                        @method('delete')

                                        <button class="btn btn-sm btn-danger"><i
                                                class="fa-sharp fa-solid fa-trash">ဖျက်ရန်</i></button>
                                    </form>

                                        <a href="{{ route('post#updatepage', $items->id) }}">
                                            <button class="btn btn-sm btn-primary"><i
                                                    class="fa-solid fa-file-invoice">အပြည့်အစုံဖတ်ရန်</i></button>
                                        </a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h3 class="text-danger text-center mt-5">There is no data....</h3>
                    @endif
                    {{ $posts->appends(request()->query())->links() }}
                    {{-- @for ($i = 0; $i < count($posts); $i++)
                        <div class="post p-3 shadow-sm mb-3">
                            <h5>{{ $posts[$i]['title'] }}</h5>
                            <p class="text-muted">{{ $posts[$i]['description'] }}</p>
                            <div class="text-end">
                                <button class="btn btn-sm btn-danger"><i class="fa-sharp fa-solid fa-trash"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fa-solid fa-file-invoice"></i></button>
                            </div>
                        </div>
                    @endfor --}}
                </div>
            </div>
        </div>
    </div>
@endsection
