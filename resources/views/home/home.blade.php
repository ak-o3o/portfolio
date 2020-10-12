@extends('layouts.base')
@section('title','En_diary Home')
@section('main')

<body>
    <div class="home">
        @if (isset($timelines))
        @foreach ($timelines as $timeline)

        <div class="post-contents">
            {{-- post --}}
            <div class="post">
                <div class="post-left">
                    {{-- @if (Storage::files('/storage/user_images/'. $timeline->user->image_file)) --}}
                    {{-- <img src="{{ asset('/storage/user_images/'. $timeline->user->image_file) }}"> --}}
                    {{-- @else --}}
                    <img src="{{ asset('/storage/default_user_img/default_user.png') }}">
                    {{-- @endif --}}

                </div>
              <div class="post-right">
                  <div class="post-txt">
                <div class="post-ja">
                    
                    <div class="post-head">
                        <div class="post-head-contents">
                            <div class="user-name">{{-- $timeline->user->name --}}</div>
                            @if ($timeline->user_id === Auth::user()->id)
                            <div class="delete">
                                <button class="delete-btn"><i class="far fa-trash-alt fa-fw"></i></button>
                            </div>
                            @endif
                        </div>
                        <div class="post-date">{{ $timeline->created_at->format('Y-m-d H:i') }}</div>    
                    </div>

                    <div class="popup-delete">
                        <div class="popup-delete-contents">
                            <button class="close-delete"><i class="fas fa-times fa-fw"></i></button>
                            <div class="popup-delete-contents">
                                <div class="delete-display">
                                    <p>are you sure want to delete post?</p>
    
                                    <input type="submit" value="Delete">
                                    <form method="POST" action="{{ url('posts/' .$timeline->id) }}" class="mb-0">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <input type="button" value="Cancel" class="close-delete">
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="post-ja-txt">
                        <p>{{ $timeline->post_ja }}</p>
                    </div>
                </div>
                <div class="post-en">
                    <div class="post-en-txt">
                        <p>{{ $timeline->post_en }}</p>
                    </div>
                    <div class="action-btn">
                        <div class="action-btn-under">
                        <a href=""><i class="far fa-comment-dots fa-fw"></i></a>{{-- count($timeline->comments) --}}
                        <a href=""><i class="far fa-star fa-fw"></i></a>{{-- count($timeline->favorites) --}}
                        @if ($timeline->user_id === Auth::user()->id)
                        <a href="{{ url('posts/' .$timeline->id .'/edit') }}"><i class="far fa-edit"></i></a>
                        @endif
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            {{-- post ここまで --}}
        </div>
        {{-- post-contents ここまで --}}
        @endforeach
        @else
        <div class="no-post">No posts yet...</div>
        @endif

        <div class="sideber">
            <div class="sideber-contents">
                <div class="sideber-btn sideber-mypage"><a href="/users/{{Auth::user()->id}}"><i class="far fa-file fa-fw"></i><span>MyPage</span></a></div>
                <div class="sideber-btn sideber-favorite"><i class="far fa-star fa-fw"></i><span>Favorite</span></div>
                <div class="sideber-btn sideber-vocabulary"><i class="fas fa-book fa-fw"></i><span>Vocabulary</span></div>
                <div class="sideber-btn sideber-help"><a href="{{ url('/home/help') }}"><i class="far fa-question-circle fa-fw"></i><span>Help</span></a></div>
                <div class="post-create">
                    <button id="post-create-btn">ToPOST</button>
                </div>
            </div>
        </div>
        <div class="popup">
            <div class="post-create-contents">
                <button id="close"><i class="fas fa-times fa-fw"></i></button>
                <hr>
                <form action="{{ url('/posts/store') }}" method="POST">
                    @csrf
                    <div class="post-txt">
                        <div class="post-ja">
                            <textarea name="post_ja" id="post_ja" cols="30" rows="10" value="{{ old('post_ja') }}" placeholder="日本文を入力してください"></textarea>
                        </div>
                        <div class="post-en">
                            <textarea name="post_en" id="post_en" cols="30" rows="10" value="{{ old('post_en') }}" placeholder="英文を入力してください"></textarea>
                        </div> 
                    </div>
                    <div class="post-create">
                        <input type="submit" value="POST">
                    </div>
                </form>
            </div>
        </div>        
    </div>
    
    <div class="vocabulary">
        <div class="vocabulary-close-contents">
            <button id="close-vocabulary"><i class="fas fa-times fa-fw"></i></button>
            <hr>
        </div>
        
       <h2>Vocabulary Book</h2>
       <div class="vocabulary-contents">
            <div class="word-txt">
                <div class="word-post-ja">
                    <textarea name="word-post-ja" id="word-post-ja" cols="30" rows="5" placeholder="日本語"></textarea>
                </div>
                <div class="word-post-en">
                    <textarea name="word-post-en" id="word-post-en" cols="30" rows="5" placeholder="英語"></textarea>
                </div>
            </div>
            <div class="word-post-create">
                <input type="submit" value="SAVE">
            </div>
            
            <div class="word">
                <div class="word-en">
                    <p>hello </p>
                </div>
                <div class="word-ja">
                    <p>おはよう</p>
                </div>
            </div>

            <div class="word">
                <div class="word-en">
                    <p>hello </p>
                </div>
                <div class="word-ja">
                    <p>おはよう</p>
                </div>
            </div>

            <div class="word">
                <div class="word-en">
                    <p>hello </p>
                </div>
                <div class="word-ja">
                    <p>おはよう</p>
                </div>
            </div>
        </div>
    </div>


    <div class="favorite">        
        <div class="favorite-close-contents">
            <button id="close-favorite"><i class="fas fa-times fa-fw"></i></button>
            <hr>
        </div>

       <div><h2>Favorite</h2></div>
       <div class="favorite-contents">
            
            <div class="favorite-post">
                <div class="favorite-en">
                    <p>englishenglishenglishenglish english english english</p>
                </div>
                <div class="favorite-ja">
                    <p>日本語日本語日本語日本語日本語日本語日本語日本語日本語
                    </p>
                </div>
            </div>
        </div>
    </div>

</body>
@endsection


