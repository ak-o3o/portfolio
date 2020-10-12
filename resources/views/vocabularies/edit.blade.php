@extends('layouts.base')
@section('title','En_diary edit')
@section('main')

<body>
    <div class="edit-vocabulary">
        <div class="post-create-contents">
            <form action="{{ url('/vocabularies', $vocabulary->id) }}" method="POST">
                {{csrf_field()}}
                {{ method_field('patch')}}

                <div class="post-txt">
                    <div class="post-en">
                        <textarea name="vocabulary_en" id="vocabulary_en" cols="30" rows="10" value="{{ old('vocabulary_en') }}" placeholder="英文を入力してください" required autocomplete="text" @error('text') is-invalid @enderror>{{ old('text') ? : $vocabulary->vocabulary_en }}
                        </textarea>
                    </div> 
                    <div class="post-ja">
                        <textarea name="vocabulary_ja" id="vocabulary_ja" cols="30" rows="10" value="{{ old('vocabulary_ja') }}" placeholder="日本文を入力してください" required autocomplete="text" @error('text') is-invalid @enderror>{{ old('text') ? : $vocabulary->vocabulary_ja }}
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
