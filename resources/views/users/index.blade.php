@extends('layouts.base')
@section('title','En_diary user')
@section('main')

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach ($all_users as $user)
                    <div class="card">
                        <div class="card-haeder p-3 w-100 d-flex">
                            @if ($user->image_file !== null)
                                <img src="{{ asset('/storage/user_images/'. $user->image_file) }}" class="rounded-circle" width="50" height="50">
                            @else
                                <img src="{{ asset('/storage/default_user_img/default_user.png') }}" class="rounded-circle" width="50" height="50">
                            @endif

                            <div class="ml-2 d-flex flex-column">
                                <a href="{{ url('users/' .$user->id) }}" class="text-secondary">{{ $user->name }}</a>
                            </div>
                            @if (auth()->user()->isFollowed($user->id))
                                <div class="px-2">
                                    <span class="px-1 bg-secondary text-light">followed</span>
                                </div>
                            @endif
                            <div class="d-flex justify-content-end flex-grow-1">
                                @if (auth()->user()->isFollowing($user->id))
                                    <form action="{{ route('unfollow', [$user->id]) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button type="submit" class="btn btn-danger">unfollow</button>
                                    </form>
                                @else
                                    <form action="{{ route('follow', [$user->id]) }}" method="POST">
                                        {{ csrf_field() }}

                                        <button type="submit" class="btn btn-primary">following</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="my-4 d-flex justify-content-center">
            {{ $all_users->links() }}
        </div>
    </div>
</body>
@endsection


