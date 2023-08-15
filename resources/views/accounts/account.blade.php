<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>{{$user->name}}のマイページ</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <x-app-layout>
    <x-slot name="header">
        {{$user->name}}
    </x-slot>
    <body>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <meta name="csrf-token" content="{{ csrf_token() }}" />
                        <div>
                          <div>{{$user->name}}</div>
                          @if($judge)
                          <button onclick="followDestroy({{ $user->id }})">フォロー解除</button>
                          @else
                          <button onclick="follow({{ $user->id }})">フォローする</button>
                          @endif
                        </div>
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
                        <script>
                          function follow(userId) {
                            $.ajax({
                              // これがないと419エラーが出ます
                              headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                              url: `/follow/${userId}`,//このurlに
                              type: "POST",//POST!
                            })
                              .done((data) => {
                                console.log(data);
                              })
                              .fail((data) => {
                                console.log(data);
                              });
                              window.location.href = "/users/{{$user->id}}";
                          }
                          
                          function followDestroy(userId) {
                            $.ajax({
                              // これがないと419エラーが出ます
                              headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                              url: `/follow/${userId}/destroy`,//このurlに
                              type: "POST",//POST!
                            })
                              .done((data) => {
                                console.log(data);
                              })
                              .fail((data) => {
                                console.log(data);
                              });
                              window.location.href = "/users/{{$user->id}}";
                          }
                        </script>
                        
                </div>
            </div>
        </div>
            
        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <p>{{$user->introduction}}</p>
                    </div>
                </div>
            </div>
        </div>
            
            
    </body>
    </x-app-layout>
</html>