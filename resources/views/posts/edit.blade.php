@extends('layouts.base')
@section('title','En_diary edit')
@section('main')

<body>
    <div class="edit">
        <div class="post-create-contents">
            @if ($user->image_file !== null)
            {{-- <img src="{{ asset('storage/user_images/' .$user->image_file) }}" class="rounded-circle" width="50" height="50"> --}}
            {{-- heroku用 --}}
            <img src="data:image/png;base64,{{ $user->image_file }}" class="rounded-circle" width="50" height="50">
            @else
            <img src="{{ asset('/storage/default_user_img/default_user.png') }}" class="rounded-circle" width="50" height="50">
            @endif

            <div class="ml-2 d-flex flex-column">
                <a href="{{ url('users/' .$user->id) }}" class="text-secondary">{{ $user->name }}</a>
            </div>
            <hr>
            <form action="{{ route('posts.update', [$posts->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="post-txt">
                    <div class="post-ja">
                        <textarea name="post_ja" id="post_ja" cols="30" rows="10" value="{{ old('post_ja') }}" placeholder="日本文を入力してください" required autocomplete="text" @error('text') is-invalid @enderror>{{ old('text') ? : $posts->post_ja }}
                        </textarea>
                       </div>
                    <div class="post-en">
                        <textarea name="post_en" id="post_en" cols="30" rows="10" value="{{ old('post_en') }}" placeholder="英文を入力してください" required autocomplete="text" @error('text') is-invalid @enderror>{{ old('text') ? : $posts->post_en }}
                        </textarea>
                    </div> 
                </div>

                <div class="col-md-12">

                    @error('text')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="post-create">
                    <input type="submit" value="Update">
                </div>
            </form>
        </div>
    </div>
</body>
@endsection

</form>
