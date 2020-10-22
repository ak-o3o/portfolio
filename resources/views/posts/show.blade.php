@extends('layouts.base')
@section('title','EN DIARY detail')
@section('main')
    

<body>

<div class="post-show">
    <div class="post-contents">
        {{-- post --}}
        <div class="post">
            <div class="post-left">
                
                @if ($post->user->image_file !== null)
                {{-- <img src="{{ asset('storage/user_images/' .$post->user->image_file) }}" class="rounded-circle" width="50" height="50"> --}}
                {{-- heroku用 --}}
                <img src="data:image/png;base64,{{ $post->user->image_file }}" class="rounded-circle" width="50" height="50">
                @else
                <img src="{{ asset('/storage/default_user_img/default_user.png') }}">
                @endif

            </div>
          <div class="post-right">
            <div class="post-txt">
             <div class="post-ja">
                
                <div class="post-head">
                    <div class="post-head-contents">
                        <div class="user-name">{{ $post->user->name }}</div>
                        @if ($post->user_id === Auth::user()->id)
                        <div class="delete">
                            <button class="delete-btn"><i class="far fa-trash-alt fa-fw"></i></button>
                        </div>
                        @endif
                    </div>
                    <div class="post-date">{{ $post->created_at->format('Y-m-d H:i') }}</div>    
                </div>

                <div class="popup-delete">
                    <div class="popup-delete-contents">
                        <button class="close-delete"><i class="fas fa-times fa-fw"></i></button>
                        <div class="popup-delete-contents">
                            <div class="delete-display">
                                <p>are you sure want to delete post?</p>

                                <form method="POST" action="{{ url('posts/' . $post->id) }}" class="mb-0">
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
                    <p>{{ $post->post_ja }}</p>
                </div>
            </div>
            <div class="post-en">
                <div class="post-en-txt">
                    <p>{{ $post->post_en }}</p>
                </div>
                <div class="action-btn">
                    <div class="action-btn-under">
                        <div class="action-btn-under-left">
                            <a href="{{ url('posts/' .$post->id) }}"><i class="far fa-comment-dots fa-fw"></i>{{ count($post->comments) }}</a>
                        </div>

                        <div class="action-btn-under-right">
                            @if (!in_array(Auth::user()->id, array_column($post->favorites->toArray(), 'user_id'), TRUE))
                                <form method="POST" action="{{ url('favorites/') }}" >
                                    @csrf

                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <button type="submit" ><i class="far fa-star fa-fw"></i>{{ count($post->favorites) }}</button>
                                    
                                </form>
                            @else
                                <form method="POST"action="{{ url('favorites/' .array_column($post->favorites->toArray(), 'id', 'user_id')[Auth::user()->id]) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-danger"><i class="far fa-star fa-fw"></i>{{ count($post->favorites) }}</button>
                                </form>
                            @endif
                        </div>
                    </div>
                        @if ($post->user_id === Auth::user()->id)
                        <a href="{{ url('posts/' .$post->id .'/edit') }}"><i class="far fa-edit"></i></a>
                        @endif

                </div>
              </div>
            </div>
          </div>
        </div>
        {{-- post ここまで --}}
    </div>
    {{-- post-contents ここまで --}}
<hr>

{{-- コメント欄 --}}
    @forelse ($comments as $comment)

    <div class="comment">
        <div class="comment-contents">

            <div class="comment-content-container">
                <div class="comment-contents-left">
                    @if ($comment->user->image_file !== null)
                    {{-- <img src="{{ asset('storage/user_images/' .$comment->user->image_file) }}" class="rounded-circle" width="50" height="50"> --}}
                    {{-- heroku用 --}}
                    <img src="data:image/png;base64,{{ $comment->user->image_file }}" class="rounded-circle" width="50" height="50">
                    @else
                    <img src="{{ asset('/storage/default_user_img/default_user.png') }}">
                    @endif
                </div>

                <div class="comment-contents-right">
                    @if ($comment->user_id === Auth::user()->id)
                    <div class="delete">
                        <button class="delete-btn"><i class="far fa-trash-alt fa-fw"></i></button>
                    </div>
                    @endif
                </div>
            </div>

          <div class="comment-txt">
             <div class="comment-head">
                <div class="comment-head-contents">
                    <div class="user-name"><a href="{{ url('users/' .$comment->user->id) }}" class="text-secondary">{{ $comment->user->name }}</a>
                    </div>
                </div>
                <div class="post-date">{{ $comment->created_at->format('Y-m-d H:i') }}</div>    
             </div>
                <div class="py-3">
                    {!! nl2br(e($comment->comment)) !!}
                </div>
            </div>
        </div>
        @empty
        <div class="no-post">No Comment yet...</div>
        @endforelse


{{-- コメント投稿 --}}
    <div class="comment-create-contents">
        <div class="col-md-12 p-3 w-100 d-flex">
            @if ($user->image_file !== null)
            {{-- <img src="{{ asset('/storage/user_images/'. $user->image_file) }}" class="rounded-circle" width="100" height="100"> --}}
            {{-- heroku用 --}}
            <img src="data:image/png;base64,{{ $user->image_file }}" class="rounded-circle" width="50" height="50">
            @else
            <img src="{{ asset('/storage/default_user_img/default_user.png') }}" class="rounded-circle" width="50" height="50">
            @endif

            <div class="ml-2 d-flex flex-column">
                <a href="{{ url('users/' .$user->id) }}" class="text-secondary">{{ $user->name }}</a>
            </div>
        </div>

        <form method="POST" action="{{ route('comments.store') }}">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <textarea class="form-control @error('text') is-invalid @enderror" name="comment" required autocomplete="comment" rows="4">{{ old('comment') }}</textarea>

            @error('text')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <div class="comment-create">
                <input type="submit" value="Comment">
            </div>
        </form>
    </div>

</div>{{-- post-showここまで --}}

</body>
@endsection