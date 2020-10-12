@extends('layouts.base')
@section('title','En_diary user pgae')
@section('main')

<body>
<div class="mypage">

    <div class="profile">
        {{-- profile表示 --}}
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 mb-3">
                    <div class="card">
                        <div class="d-inline-flex">
                            <div class="p-3 d-flex flex-column">
                                <img src="{{ asset('/storage/user_images/'. $user->image_file) }}" class="rounded-circle" width="100" height="100">
                                <div class="mt-3 d-flex flex-column">
                                    <h4 class="mb-0 font-weight-bold">{{ $user->name }}</h4>
                                </div>
                            </div>
                            <div class="p-3 d-flex flex-column justify-content-between">
                                <div class="d-flex">
                                    <div>
                                        @if ($user->id === Auth::user()->id)
                                            <a href="{{ url('users/' .$user->id .'/edit') }}" class="btn btn-primary">Edit profile</a>
                                        @else
                                            @if ($is_following)
                                                <form action="{{ route('unfollow', [$user->id]) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
        
                                                    <button type="submit" class="btn btn-danger">unfollow</button>
                                                </form>
                                            @else
                                                <form action="{{ route('follow', [$user->id]) }}" method="POST">
                                                    {{ csrf_field() }}
        
                                                    <button type="submit" class="btn btn-primary">follow</button>
                                                </form>
                                            @endif
        
                                            @if ($is_followed)
                                                <span class="mt-2 px-1 bg-secondary text-light">Follows you</span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <div class="p-2 d-flex flex-column align-items-center">
                                        <p class="font-weight-bold">Posts</p>
                                        <span>{{ $post_count }}</span>
                                    </div>
                                    <div class="p-2 d-flex flex-column align-items-center">
                                        <p class="font-weight-bold">Following</p>
                                        <span>{{ $follow_count }}</span>
                                    </div>
                                    <div class="p-2 d-flex flex-column align-items-center">
                                        <p class="font-weight-bold">Follower</p>
                                        <span>{{ $follower_count }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>        
            </div>
        </div>
    </div>  {{-- profile表示ここまで --}}
    <hr>

        {{-- TL表示 --}}
        <div class="mytl">
            @if (isset($timelines))
            @foreach ($timelines as $timeline)
            <div class="post-contents">
                {{-- post --}}
                <div class="post">
                    <div class="post-left">
                        <img src="{{ asset('/storage/user_images/'. $user->image_file) }}">
        
                    </div>
                  <div class="post-right">
                      <div class="post-txt">
                    <div class="post-ja">
                        
                        <div class="post-head">
                            <div class="post-head-contents">
                                <div class="user-name">{{$user->name}}</div>
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
        
                                        <form method="POST" action="{{ url('posts/' .$timeline->id) }}" class="mb-0">
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
            <div class="no-post">No posts yet...</div>
            @endif
        </div>{{-- mytl ここまで --}}

            <div class="my-4 d-flex justify-content-center">
                {{ $timelines->links() }}
            </div>
            <hr>

</div>{{-- mypage ここまで --}}

   <!-- jquery.min.js -->
   <script src="js/jquery.min.js"></script>
    <!--Java Script-->
    <script src="js/scripts.js"></script>
</body>
@endsection


