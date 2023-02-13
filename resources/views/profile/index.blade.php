@extends('layouts.profile')

@section('content')
    <div class="container">
        <hr color="c0c0c0">
        @if (!is_null($headline))
            <div class="row">
                <div class="headline col-md-10 mx-auto">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="caption mx-auto">
                                <div class="image">
                                    @if ($headline->image_path)
                                        <img src="{{ secure_asset('storage/image/' . $headline->image_path) }}">
                                    @endif
                                </div>
                                <div class="name p-2">
                                    <h1> {{ Str::limit($headline->name, 70) }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <p class="gender mx-auto">{{ Str::limit($headline->gender, 650) }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="hobby mx-auto">{{ Str::limit($headline->hobby, 650) }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="introduction mx-auto">{{ Str::limit($headline->introduction, 650) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <hr color="#c0c0c0">
        <div class="row">
            <div class="posts col-md-8 mx-auto mt-3">
                @foreach($posts as $post)
                    <div class="post">
                        <div class="row">
                            <div class="text col-md-6">
                                <div class="date">
                                     {{ $post->updated_at->format('Y年m月d日') }}
                                     <!--formatメソッドは、フォーマットするためのメソッド。formatメソッドを使えば、簡単に日付のフォーマットを変更-->
                                </div>
                                <div class="name">
                                    {{ Str::limit($post->name, 150) }}
                                </div>
                                <div class="gender mt-3">
                                    {{ Str::limit($post->gender, 1500) }}
                                </div>
                                <div class="hobby mt-3">
                                    {{ Str::limit($post->hobby, 1500) }}
                                </div>
                                <div class="introduction mt-3">
                                    {{ Str::limit($post->introduction, 1500) }}
                                </div>
                            </div>
                            <div class="image col-md-6 text-right mt-4">
                                @if ($post->image_path)
                                    <img src="{{ secure_asset('storage/image/' . $post->image_path) }}">
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr color="#c0c0c0">
                @endforeach
            </div>
        </div>
    </div>
    </div>
@endsection