<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Blog</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <h1 class = 'title'>
            {{$post->title}}
        </h1>
        <div class='content'>
            　<div class='content_post'>
                <h3>本文</h3>
                <p class='body'>{{ $post->body }}</p>
            　</div>
            @if($post->image_url)　
                <div>
                    <img src="{{ $post->image_url }}" alt="画像が読み込めません。"/>
                </div>
            @endif
        </div>
        <a href="/categories/{{ $post->category->id }}">{{ $post->category->name }}</a>
        <div class= 'edit'>
            <a href = "/posts/{{$post->id}}/edit">再編集</a>
        </div>
        <div class= 'footer'>
            <a href = "/">戻る</a>
        </div>
        <div class="comment">
            <form method="POST" action="/comment">
                @csrf
                <input type="hidden" name='post_id' value="{{$post->id}}">
                <div>
                    <textarea name="comment" class="form-control" id="body" cols="30" rows="5" placeholder="コメントを入力する">{{old('body')}}</textarea>
                </div>
                <div>
                    <button>コメントする</button>
                </div>
                @foreach ($post->comments as $comment)
                <div>
                    <div>
                        {{$comment->user->name}}
                    </div>
                    <div>
                        {{$comment->comment}}
                    </div>
                    <div>
                    <span>
                        投稿日時 {{$comment->created_at->diffForHumans()}}
                    </span>
                    </div>
                </div>
                @endforeach
            </form>
        </div>
    </body>
</html>