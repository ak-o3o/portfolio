@extends('layouts.base')
@section('title','En_diary Home')
@section('main')

<body>

    <div class="home">
   
        @if (isset($timelines[0]))
        @foreach ($timelines as $timeline)
        <div class="post-contents">
            {{-- post --}}
            <div class="post">
                <div class="post-left">
                    
                    @if ($timeline->user->image_file !== null)
                    <img src="{{ asset('/storage/user_images/'. $timeline->user->image_file) }}">
                    @else
                    <img src="{{ asset('/storage/default_user_img/default_user.png') }}">
                    @endif

                </div>
              <div class="post-right">
                  <div class="post-txt">
                    <div class="post-ja">
                    
                        <div class="post-head">
                            <div class="post-head-contents">
                                <div class="user-name">{{ $timeline->user->name }}</div>
                                @if ($timeline->user_id === Auth::user()->id)
                                <div class="delete">
                                    <button id="no{{$timeline->id}}" class="delete-btn"><i class="far fa-trash-alt fa-fw"></i></button>
                                </div>
                                @endif
                            </div>
                            <div class="post-date">{{ $timeline->created_at->format('Y-m-d H:i') }}</div>    
                        </div>

                        <div class="popup-delete" id="delete-id{{$timeline->id}}" >
                            <div class="popup-delete-contents">
                                <button class="close-delete"><i class="fas fa-times fa-fw"></i></button>
                                <div class="popup-delete-contents">
                                    <div class="delete-display">
                                        <p>are you sure want to delete post?</p>

                                        <form method="POST" action="{{ url('posts/' . $timeline->id) }}" class="mb-0">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" value="Delete">
                                            @csrf
                                            @method('DELETE')
                                            <input type="button" value="Cancel" class="close-delete">
                                        </form>

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
                                <div class="action-btn-under-left">
                                    <a href="{{ url('posts/' .$timeline->id) }}"><i class="far fa-comment-dots fa-fw"></i>{{ count($timeline->comments) }}</a>
                                </div>

                                <div class="action-btn-under-right">
                                    @if (!in_array(Auth::user()->id, array_column($timeline->favorites->toArray(), 'user_id'), TRUE))
                                        <form method="POST" action="{{ url('favorites/') }}" >
                                            @csrf
                                            <input type="hidden" name="post_id" value="{{ $timeline->id }}">
                                            <button type="submit" ><i class="far fa-star fa-fw"></i>{{ count($timeline->favorites) }}</button> 
                                        </form>
                                    @else
                                        <form method="POST"action="{{ url('favorites/' .array_column($timeline->favorites->toArray(), 'id', 'user_id')[Auth::user()->id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-danger"><i class="far fa-star fa-fw"></i>{{ count($timeline->favorites) }}</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                                @if ($timeline->user_id === Auth::user()->id)
                                <a href="{{ url('posts/' .$timeline->id .'/edit') }}"><i class="far fa-edit"></i></a>
                                @endif
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
        <div class="no-post">
            <p>日記を書いてみましょう</p>
            <p>気になる人をフォローしてみましょう</p>
        </div>
        @endif

        <div class="sideber">
            <div class="sideber-contents">
                <div class="sideber-btn sideber-mypage"><a href="/users/{{Auth::user()->id}}"><i class="far fa-file fa-fw"></i><span>MyPage</span></a></div>
                <div class="sideber-btn sideber-search"><a href="/users"><i class="fas fa-search fa-fw"></i><span>Search</span></a></div>
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
        <div class="my-4 d-flex justify-content-center">
            {{ $timelines->links() }}
        </div>  
    </div>{{--homeここまで--}}
    
    <div class="vocabulary">
        <div class="vocabulary-close-contents">
            <button id="close-vocabulary"><i class="fas fa-times fa-fw"></i></button>
            <hr>
        </div>
        
       <h2>Vocabulary Book</h2>
       <div class="vocabulary-contents">
        <form action='{{ url('/vocabularies')}}' method="post">
            {{csrf_field()}}
            <div class="word-txt">
                <div class="word-post-en">
                    <textarea name="vocabulary_en" id="vocabulary_en" cols="30" rows="5" placeholder="英語"></textarea>
                </div>
                <div class="word-post-ja">
                    <textarea name="vocabulary_ja" id="vocabulary_ja" cols="30" rows="5" placeholder="日本語"></textarea>
                </div>
            </div>
            <div class="word-post-create">
                <input type="submit" value="SAVE">
            </div>
        </form>
           
            @foreach ($vocabularies as $vocabulary)
            <div class="word">
                <div class="word-en">
                    <form action="{{ url('/vocabularies', $vocabulary->id) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}

                        <div class="word-delete">
                            <button type="submit"><i class="far fa-trash-alt fa-fw"></i></button>
                        </div>
                    </form>
                    <div class="word-txt">
                        <p>{{ $vocabulary->vocabulary_en }}</p>
                    </div>
                </div>

                <div class="word-ja">
                    <form action="{{ action('VocabulariesController@edit', $vocabulary) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('get') }}

                        <div class="word-txt">
                            <p>{{ $vocabulary->vocabulary_ja }}</p>
                        </div>
                        <div class="word-edit">
                            <button type="submit"><i class="far fa-edit"></i></button>
                        </div>
                    </form>
                </div>
            </div>{{--wordここまで--}}
            @endforeach

        </div>{{--vocabulary-contentsここまで--}}
    </div>{{--vocabularyここまで--}}

</body>
@endsection


