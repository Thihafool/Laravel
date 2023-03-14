<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Dflydev\DotAccessData\Data;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    //customer create page
    public function create()
    {


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
            $request->file('postImage')->storeAs('public', $fileName);
            $data['image'] = $fileName;
        }

        Post::create($data);
        return redirect()->route('post#createPage')->with(['insertSuccess' => 'Postဖန်တီးခြင်းအောင်မြင်ပါသည်']); //route name
    }
    //post delete
    public function postDelete($id)
    {

        $post = Post::find($id);
        $post->delete();
        return back();
    }

    //update page

    public function updatePage($id)

    {

        $post = Post::where('id', $id)->first();
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

        $this->postValidationCheck($request);

        $updateData = $this->getPostData($request);
        $id = $request->postId;

        // dd($request->hasfile('postImage')? 'yes':'no');

        if ($request->hasFile('postImage')) {

            //delete existing photo
            $oldImageName = Post::select('image')->where('id',$request->postId)->first()->toArray();

            $oldImageName = $oldImageName['image'];

            if($oldImageName != null){
                Storage::delete('public/'.$oldImageName);
            }

            // $request->file('postImage')->store('myImage');
            $fileName = uniqid() . $request->file('postImage')->getClientOriginalName();
            $request->file('postImage')->storeAs('public', $fileName);
            $updateData['image'] = $fileName;
        }


        Post::where('id', $id)->update($updateData);
        return redirect()->route('post#createPage')->with(['updateSuccess' => 'updateလုပ်ခြင်းအောင်မြင်ပါသည်']);;
    }


    //get post data
    private function getPostData($request)
    {
        $data = [
            'title' => $request->postTitle,
            'description' => $request->postDescription,
        ];

        $data['price'] = $request->postFees == null ? 2000 : $request->postFees ;
        $data['address'] = $request->postAddress == null ? 'Japan' : $request->postAddress;
        $data['rating'] = $request->postRating == null ? 3 : $request->postRating;

        return $data;

    }
    //post validation check
    private function postValidationCheck($request)
    {

        $validationRules = [
            'postTitle' => 'required|min:5|max:15|unique:posts,title,' . $request->postId,
            'postDescription' => 'required|min:5',
            // 'postFees' => 'required',
            // 'postAddress' => 'required',
            // 'postRating' => 'required',
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
