<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    public function index(Post $post)
    {
       //blade内で使う変数'posts'と設定。'posts'の中身にgetを使い、インスタンス化した$postを代入。
       // クライアントインスタンス生成
        $client = new \GuzzleHttp\Client();

        // GET通信するURL
        $url = 'https://teratail.com/api/v1/questions';

        // リクエスト送信と返却データの取得
        // Bearerトークンにアクセストークンを指定して認証を行う
        $response = $client->request(
            'GET',
            $url,
            ['Bearer' => config('services.teratail.token')]
        );
        
        // API通信で取得したデータはjson形式なので
        // PHPファイルに対応した連想配列にデコードする
        $questions = json_decode($response->getBody(), true);
        
        // index bladeに取得したデータを渡す
        return view('posts.index')->with([
            'posts' => $post->getPaginateByLimit(),
            'questions' => $questions['questions'],
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
        $input = $request['post']; //$reqest['inptやtextareaのname']という風にして、$inputに入れる　この'post'はcreate.bladeのinput、textareaのnameとしてのpost
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
    
}
?>
