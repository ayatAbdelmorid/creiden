<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Auth;
use Validator;
use Illuminate\Validation\Rule;
class WordpressController extends Controller
{
    public function index(){

        config('wordpress.WP_URL');
        $client = new Client();
        $res = $client->request('Get', env('WP_URL').'/index.php/wp-json/twentytwenty/v1/custom_posts_type');
        $status= $res->getStatusCode(); // 200
        $posts=collect(json_decode($res->getBody(), true)); // { "type": "User", ....
        $data=[];
        $data['posts']=$posts;

         return view('wpPosts.index',$data);

    }
    public function edit($post_id=null)
    {
        $data=[];

        if(isset($post_id)){
        $client = new Client();
        $res = $client->request('Get', env('WP_URL','').'/index.php/wp-json/twentytwenty/v1/custom_post_type/'.$post_id);
        $status= $res->getStatusCode(); // 200
        $post=json_decode($res->getBody(), true)[0]; // { "type": "User", ....
        $data['post']=$post;
        }
        return view('wpPosts.edit', $data);
    }

    public function store(Request $request,$post_id=null)
    {
        $admin=Auth::guard('admin')->user();
        $token= $admin->wordpressToken();

        $validatedData =  $request->validate([
            'title' => 'required|string|max:255',
            'editor' => 'required|string',
            // 'status' => ['nullable',Rule::in(['publish','private','pending'])],
            'excerpt' => 'nullable|string',
        ]);
        if(isset($post_id)){
           $url= env('WP_URL','').'/index.php/wp-json/twentytwenty/v1/custom_post_type/'.$post_id;
        }else{
            $url=env('WP_URL','').'/index.php/wp-json/twentytwenty/v1/custom_post_type';
        }
        $client = new Client();

        $res = $client->request('Post', $url,
            ['headers' =>['Authorization' => "Bearer {$token}"],
            // "query" => ["slug"=> $post_slug],
            "form_params" => $validatedData
            ]);
        $status= $res->getStatusCode(); // 200
        $post=json_decode($res->getBody(), true)[0]; // { "type": "User", ....
        $data=[];
        $data['post']=$post;
        return  redirect()->route('wordpress.index_posts')->with('success', 'Post updated successfully');
    }



    public function show($post_id)
    {
        $client = new Client();
        $res = $client->request('Get', env('WP_URL','').'/index.php/wp-json/twentytwenty/v1/custom_post_type/'.$post_id);
        $status= $res->getStatusCode(); // 200
        $post=json_decode($res->getBody(), true)[0]; // { "type": "User", ....
        $data=[];
        $data['post']=$post;

        return view('wpPosts.show', $data);
    }

    public function destroy($post_id)
    {
        // $admin=Auth::guard('admin')->user();
        // $token= $admin->wordpressToken();

        $client = new Client(['http_errors' => false]);
        $res = $client->request('DELETE',env('WP_URL','').'/index.php/wp-json/twentytwenty/v1/custom_post_type/'.$post_id
            // ,['headers' =>
            //     [
            //         'Authorization' => "Bearer {$token}"
            //     ]
            // ]
        );
        if($res->getStatusCode()!=200){
            return   redirect()->route('wordpress.index_posts')->with('error', 'something went wrong');

        }

        return   redirect()->route('wordpress.index_posts')->with('success', 'Post deleted successfully');

    }


}
