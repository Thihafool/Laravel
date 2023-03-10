<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    //customer create page
    public function create()
    {
        // $posts = Post::all()->toArray(); //get
        // $posts = Post::orderBy('created_at', 'desc')->paginate(3); //scan data
        // $posts = Post::where('id', '<', '6')->where('address', '=', 'Yangon')->get();
        // $posts = Post::get()->pluck('title');

        // $posts = Post::where('id', '<', 11)->get()->random();
        // $posts = Post::where('address', 'Yangon')->get()->random();
        // $posts = Post::where('id', '<', '6')->pluck('title');

        // $posts = Post::where('id', '<', 5)->orwhere('address', 'Yangon')->get();
        // $posts = Post::orderBy('price', 'desc')->get();
        // $posts = Post::select('id', 'address', 'price')->where('address', 'Yangon')->whereBetween('price', [2000, 9000])->orderBy('price', 'asc')->get();

        // $posts = Post::where('address', 'Yangon')->orderBy('price', 'asc')->dd();

        // $posts = DB::table('posts')->select('title', 'price')->where('address', 'Yangon')->get()->toArray();

        //map each through


        // map each =>paginate =>Data
        // through =>paginage =>pagination + Data

        // $posts = Post::get()->each(function ($post)
        // $posts = Post::paginate(5)->through(function ($post) {
        //     $post->title = strtoupper($post->title);
        //     $post->description = strtoupper($post->description);
        //     $post->price = $post->price * 2;
        //     return $post;
        // });



        // $posts = Post::find(3);
        // $posts = Post::where('id', 3)->first(); //same
        // $posts = Post::avg('price');
        // $posts = Post::select('id', 'title as post_title', 'title')->get()->toArray();

        // $posts = Post::select('address', DB::raw('COUNT(address) as user_count', 'address_count'), DB::raw('AVG(price) as total_price'))
        //     ->groupBy('address')->get()->toArray();


        // $posts = Post::select('rating', DB::raw('COUNT(rating) as rating_count', 'rating_count'), DB::raw('AVG(price) as total_price'))
        //     ->groupBy('rating')->get()->toArray();
        // $posts = Post::count();
        // $posts = Post::select('title')->get();
        // dd($posts->toArray());
        // dd($posts->toArray());

        // $posts = Post::orderBy('created_at', 'desc')->get();
        // dd($posts->toArray());
        // // dd($posts);
        // dd($posts[0]['title']);

        // http://localhost/lara-test/public/customer/createPage?key =code lab

        // $searchKey = ($_REQUEST['key']);
        // $post = Post::where('title', 'like', '%' . $searchKey . '%')->get()->toArray();

        // $post = Post::when(request('key'), function ($p) {
        //     $searchKey = request('key');
        //     $p->where('title', 'like', '%' . $searchKey . '%');
        // })->paginate(4);

        // dd($post->toArray());

        // http://localhost/lara-test/public/customer/createPage?
        // http://localhost/lara-test/public/customer/createPage?page=2
        // http://localhost/lara-test/public/customer/createPage?searchKey=thi+ha

        $posts = Post::when(request('searchKey'), function ($query) {
            $key = request('searchKey');
            $query->orwhere('title', 'like', '%' . $key . '%')
                ->orwhere('description', 'like', '%' . $key . '%');
        })->orderBy('created_at', 'desc')->paginate(4);
        return view('create', compact('posts')); //['posts'=>$posts]

    }

    //post create
    public function postCreate(Request $request)
    {
        $this->postValidationCheck($request);
        $data = $this->getPostData($request);
        // dd($request->file('postImage'));


        if ($request->hasFile('postImage')) {
            // $request->file('postImage')->store('myImage');
            $fileName = uniqid() . $request->file('postImage')->getClientOriginalName();
            $request->file('postImage')->storeAs('myImage', $fileName);
            $data['image'] = $fileName;
        }


        // dd($request->hasFile('postImage') ? 'yes' : 'no');
        // $validationRules = [
        //     'postTitle' => 'required',
        //     'postDescription' => 'required'
        // ];
        // Validator::make($request->all(), $validationRules)->validate();


        // $data = $this->getPOstData($request);
        Post::create($data);
        // return view('create');
        // return back();
        // return redirect('testing'); //get method only url
        return redirect()->route('post#createPage')->with(['insertSuccess' => 'Postဖန်တီးခြင်းအောင်မြင်ပါသည်']); //route name
    }
    //post delete
    public function postDelete($id)
    {
        //first way
        // Post::where('id', $id)->delete();
        // return redirect()->route('post#createPage');
        // return view('create');
        // return back();


        //second way
        // $post = Post::find($id)->delete();
        $post = Post::find($id);
        $post->delete();
        return back();
    }

    //update page

    public function updatePage($id)

    {

        // $post = Post::first()->toArray();
        $post = Post::where('id', $id)->get();
        // $post = Post::where('id', $id)->get()->toArray();
        // $post = Post::find($id)->get()->toArray();

        return view('update', compact('post'));
    }

    //edit page
    public function editPage($id)
    {
        $post = Post::where('id', $id)->first()->toArray();

        return view('edit', compact('post'));
    }

    //update post
    public function update(Request $request)
    {
        // dd($request->postId);
        // $this->postValidationCheck($request);


        $updateData = $this->getPostData($request);
        $id = $request->postId;

        Post::where('id', $id)->update($updateData);
        return redirect()->route('post#createPage')->with(['updateSuccess' => 'updateလုပ်ခြင်းအောင်မြင်ပါသည်']);;
    }

    // get update data


    // private function getUpdateData(Request $request)
    // {
    //     return [
    //         'title' => $request->updateName,
    //         'description ' => $request->updateDescription
    //     ];
    // }


    //get post data
    private function getPostData($request)
    {
        return [
            'title' => $request->postTitle,
            'description' => $request->postDescription,
            'price' => $request->postFees,
            'address' => $request->postAddress,
            'rating' => $request->postRating

        ];


        // $response = [
        //     'title' => $request->postTitle,
        //     'description' => $request->postDescription
        // ];

        // return $response;
    }
    //post validation check
    private function postValidationCheck($request)
    {

        $validationRules = [
            'postTitle' => 'required|min:5|max:15|unique:posts,title,' . $request->postId,
            'postDescription' => 'required|min:5',
            'postFees' => 'required',
            'postAddress' => 'required',
            'postRating' => 'required',
            'postImage' => 'mimes:jpg,jpeg,png|file'
        ];



        $validationMessage = [
            'postTitle.required' => 'Post Title ဖြည့်ရန်လိုအပ်ပါသည်',
            'postDescription.required' => 'post Description ဖြည့်ရန်လိုအပ်ပါသည်',
            'postDescription.min' => 'အနည်းဆုံးငါးလုံးအထက်ရှိရပါမည်',
            'postTitle.min' => 'အနည်းဆုံး ငါးလုံးအထက်ရှိရပါမည်',
            'postTitle.unique' => 'ခေါင်းစဉ်တူနေပါသည် ထပ်မံရိုက်ကြည့်ပါ',
            'postFees.required' => 'Post fees ဖြည့်ရန်လိုအပ်ပါသည်',
            'postAddress.required' => 'Post address ဖြည့်ရန်လိုအပ်ပါသည်',
            'postRating.required' => 'Post rating ဖြည့်ရန်လိုအပ်ပါသည်',
            'postImage.mimes' => 'Imageသည် png jpeg jpg type သာဖြစ်ရပါမည်',
            'postImage.file' => 'Image သည် file သာဖြစ်ရပါမည်'
        ];
        Validator::make($request->all(), $validationRules, $validationMessage)->validate();
    }
}
