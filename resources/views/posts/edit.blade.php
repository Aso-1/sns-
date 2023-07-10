<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Blog</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
   <body>
    <h1 class="title">編集画面</h1>
    <div class="content">
        <form action="/posts/{{ $post->id }}" method="POST">　<!--POSTリクエストではなく下記の@PUTでPUTリクエストを送っている。つまりweb.phpのpostが反応する。-->
            @csrf
            @method('PUT')
            <div class='content__title'>
                <h2>タイトル</h2>
                <input type='text' name='post[title]' value="{{ $post->title }}"><!--表示結果から分かるように、$postには編集するidのデータがすでに入っている。valueには内容が入る
                これは$postはcontrollerから渡されているが一体どこで?暗黙の結合？＝暗黙の結合のおかげでした-->
            </div>
            <div class='content__body'>
                <h2>本文</h2>
                <input type='text' name='post[body]' value="{{ $post->body }}">
            </div>
            <input type="submit" value="保存"><!--subitでformタグ内の処理をactionに書いたリンク先に送る。-->
        </form>
    </div>
</body>
</html>