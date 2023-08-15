<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>SNS(仮)</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <x-app-layout>
    <x-slot name="header">
        　INDEX
    </x-slot>
    <body>
        <h1>SNS(仮)</h1>
        <a href='/posts/create'>create</a>
        <div class='posts'>
            @foreach ($posts as $post)
            　<div class='post'>
            　    <p>アカウント名：<a href="/users/{{$post->user->id}}">{{$post->user->name}}</a></p>
                <h2 class='title'><a href="/posts/{{ $post->id }}">{{ $post->title }}</a></h2>
                <p class='body'>{{ $post->body }}</p>
                <a href="/categories/{{ $post->category->id }}">{{ $post->category->name }}</a><!--カテゴリー-->
                <p>{{Str::limit($post->created_at,13,'')}}時</p><!--投稿日時 省略版-->
                <form action="/posts/{{ $post->id }}" id="form_{{ $post->id }}" method="post"><!--これはDELETEメソッドで、DELETEリクエストを出す-->
                @csrf
                @method('DELETE')
                <button type="button" onclick="deletePost({{ $post->id }})">削除</button> 
                </form>
                <div>
                    @if ($post->comments->count())
                        <span>
                            返信 {{$post->comments->count()}}件
                        </span>
                    @else
                        <span></span>
                    @endif
                </div>
            　</div>
            @endforeach
            </div>     
            {{ Auth::user()->name }}
        <div class='paginate'>
            {{ $posts->links() }} 
        </div> <!--一番後ろにjavascriptを書く理由として、htmlを先に読み込むことで表示速度を上げることが出来るから。deletePostの引数はidとなっている。これにはonclickの$post->idの部分が入る。-->
        <script>
        function deletePost(id) {
            'use strict'
            if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
            document.getElementById(`form_${id}`).submit();
            }
        }
        </script>
    </body>
    </x-app-layout>
</html>