@extends('layout')
@section('main')
    <main class="container" style="background-color:#fff; ">
        <section id="contact-us">
            <h1 style="padding-top: 50px">Create New Post!</h1>
            @if(session('status'))
                <p>{{session('status')}}</p>
            @endif
            <div class="contact-form">
                <form action="{{route('blog.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <label for="title"><span>Title</span></label>
                    <input type="text" id="title" name="title" value="{{old('title')}}">
                    @error('title')
                        <p style="color: red; margin-bottom: 20px;">{{$message}}</p>
                    @enderror
                    <label for="image"><span>Image</span></label>
                    <input type="file" id="image" name="image">
                    @error('image')
                        <p style="color: red; margin-bottom: 20px;">{{$message}}</p>
                     @enderror
                    <label for="body"><span>body</span></label>
                    <textarea name="body">{{old('title')}}</textarea>
                    @error('body')
                        <p style="color: red; margin-bottom: 20px;">{{$message}}</p>
                    @enderror
                    <input type="submit" value="submit">
                </form>
            </div>
        </section>
    </main>
@endsection