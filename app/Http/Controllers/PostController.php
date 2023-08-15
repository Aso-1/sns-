<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;//ログインユーザーのやつ
use App\Models\User;
use Cloudinary;

class PostController extends Controller
{
    public function index(Post $post)
    {
        // index bladeに取得したデータを渡す
        return view('posts.index')->with([
            'posts' => $post->getPaginateByLimit()
        ]);
    }
    public function show(Post $post)
    {
        return view('posts.show')->with(['post' => $post]);
    //'post'はbladeファイルで使う変数。中身は$postはid=1のPostインスタンス。
    }
    public function create(Category $category)
    {
    return view('posts.create')->with(['categories' => $category->get()]);
    }
    public function store(PostRequest $request, Post $post) //新たにReqestモデルが登場　Reqestモデルにはユーザーが入力した情報があるので、Reqestモデルからnewした変数を使うことでそれらにアクセスできるようになる　気づいたらREquestのuse宣言してた
    {                                                   //毎回インスタンス化している$postに関して、「空の」Postモデルのインスタンスという表現がすごいしっくりきた
        $post->user_id = Auth::id();
        $input = $request['post']; //$reqest['inptやtextareaのname']という風にして、$inputに入れる　この'post'はcreate.bladeのinput、textareaのnameとしてのpost
        if($request->file('image')){
            $image_url = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
            $input += ['image_url' => $image_url];  //追加
        }
        $post->fill($input)->save(); //fill関数を使うと、reqestデータが入った$inputの内容を$postの形式に上書き(fillableで定義したものだけ上書きできる)し、postモデルを通してテーブルに入力データをsave。saveは六章のデータ管理の時に出てきたinsert構文を実施できる。
        return redirect('/posts/' . $post->id);//作った記事詳細画面にリダイレクト
    }
    public function edit(Post $post)//今回の$postはshow->urlから渡ってきたidを元にインスタンス化されているらしい。
    {
        return view('posts.edit')->with(['post' => $post]); //暗黙の結合により、この時点で空の$postじゃない
    }
    public function update(PostRequest $request, Post $post) //PostRequestクラスどこでつくった??Http.RequestsにPostRequest.phpがある。
    //Requestモデルには
    {
        $input_post = $request['post'];
        $post->fill($input_post)->save();
        return redirect('/posts/' . $post->id);
    }
    public function delete(Post $post)
    {
    $post->delete();
    return redirect('/');
    }
    public function account(User $user){
        $users = Auth::user()->follows()->get();//ログインしてるユーザーidに紐づいているfollowed_user_idを全件取得している。
        $judge = false;
        foreach($users as $followed){
            if($followed->id === $user->id){
                $judge = true;
                break;
            }
        }
        return view ('accounts/account')->with(['user' => $user,'judge'=>$judge]);//アカウントページにとぶ
    }
    public function introduction(Request $request)
    {
        $user = Auth::user();
        $input = $request['users'];
        $user->fill($input)->save();
        return redirect('/profile');
    }
    
}
?>
