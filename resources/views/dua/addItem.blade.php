@extends('layouts.layout')

@section('content')
    <div class="contentInputFrom p-3">
        <div class="header">
            <h2>Create Dua</h2>
        </div>
        @if(session()->has('message'))
            <div class="alert alert-danger w-100 mt-2 mb-2" id="message">
                {{ session()->get('message') }}
            </div>
        @endif
        <div class="inputGroup mt-5">
            <form action="{{route('dua.store-item')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('post')
                <div class="row">
                    <div class="col-6 s-12">
                        {{--                        // title --}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Title</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                                   placeholder="Enter Title" name="title" required>
                        </div>
                        @error('title')
                        <p class="mb-0 pb-4 text-caption text-danger">{{ $message }}</p>
                        @enderror
                        {{--                        /// category--}}
                        <div class="form-group">
                            <label for="inputState">Select Category</label>
                            <select id="inputState" class="form-control" name="category" required>
                                <option selected>Choose...</option>
                                @foreach($dua as $d)
                                    <option value="{{$d->id}}">{{$d->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('category')
                        <p class="mb-0 pb-4 text-caption text-danger">{{ $message }}</p>
                        @enderror

                        {{--                        /// content --}}
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Content English</label>
                            <textarea class="form-control summernote" id="exampleFormControlTextarea1 description"
                                      rows="3" placeholder="Write Content" name="content_en" required></textarea>
                        </div>
                        @error('content')
                        <p class="mb-0 pb-4 text-caption text-danger">{{ $message }}</p>
                        @enderror

                        {{--                        ar --}}
                        {{--                        /// content --}}
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Content Arabic</label>
                            <textarea class="form-control summernote" id="exampleFormControlTextarea1 description"
                                      rows="3" placeholder="Write Content" name="content_ar" required></textarea>
                        </div>
                        @error('content')
                        <p class="mb-0 pb-4 text-caption text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-6 s-12">

                        {{--                        // featured image --}}
                        <div class="custom-file mt-4">
                            <input type="file" class="custom-file-input" id="customFile" accept="audio/*" name="file"
                                   onchange="loadFile(event)">
                            <label class="custom-file-label" for="customFile">Upload Audio</label>
                        </div>
                        @error('image')
                        <p class="mb-0 pb-4 text-caption text-danger">{{ $message }}</p>
                        @enderror
                        {{--                        <div class="image-preview mt-3 mb-3" id="preview">--}}
                        {{--                            <h5 class=" pb-2">Image Preview</h5>--}}
                        {{--                            <audio id="music" controls>--}}
                        {{--                                <source src="url" id="output" type="audio/mpeg">--}}
                        {{--                            </audio>--}}
                        {{--                        </div>--}}


                    </div>
                    <div class="button w-100 p-4">
                        <button class="btn btn-primary w-100">
                            SAVE
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        document.getElementById('preview').style.display = "none";

        function loadFile(event) {
            // var output = document.getElementById('output');
            // output.src = URL.createObjectURL(event.target.files[0]);
            // if(output.src)
            // {
            //     document.getElementById('preview').style.display = "block";
            //     URL.revokeObjectURL(output.src) // free memory
            //     output.play()
            // }

        }

        const item = document.getElementById('message');
        setTimeout(function () {
            item.style.display = 'none'
        }, 5000);
    </script>
@endsection
