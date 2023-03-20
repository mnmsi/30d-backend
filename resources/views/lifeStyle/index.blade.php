@extends('layouts.layout')
@section('content')
    <div class="p-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="header p-2">
                <h2>Life Style</h2>
            </div>
            <div class="addNew p-2">
{{--                <a href="{{ route('life-style-create-page') }}" class="btn btn-primary mr-3"><i--}}
{{--                        class="mdi mr-2 mdi-plus"></i>Add Category</a>--}}
                <a href="{{ route('life-style-create-page') }}" class="btn btn-dark"><i class="mdi mr-2 mdi-plus"></i>Add
                    Content</a>
            </div>
        </div>
        @if(session()->has('message'))
            <div class="alert alert-success w-100 mt-2 mb-2" id="message">
                {{ session()->get('message') }}
            </div>
        @endif
        <div class="listOfContentType mt-3">
            <div class="PillButton">

                <nav>
                    <ul class="p-0">
                        <li><a class="{{ (request()->is('life-style')) ? 'active':'' }} mb-3"
                               href="{{route('life-style')}}">All</a></li>
                        <li><a href="{{route('specific-content','Sports')}}"  class="{{ (\Request::getRequestUri() == '/life-style/content/Sports' ? 'active':'' )}} mb-3">Sports</a></li>
                        <li><a href="{{route('specific-content','Voeding')}}"  class="{{ (\Request::getRequestUri() == '/life-style/content/Voeding' ? 'active':'' )}} mb-3">Voeding</a></li>
                    </ul>
                </nav>
            </div>
            <div class="row mt-3">
                @foreach($contents as $content)
{{--                    {{dd($content)->toArray()}}--}}
                    <div class="col-lg-3 col-xl-3 col-md-3 col-sm-12">
                        <div class="card w-100">
                            <div class="tag p-2">
                                <p>{{$content->categoryId->category_name}}</p>
                            </div>
                            <img class="card-img-top w-100"
                                 src="{{asset('storage/'.$content->featured_image)}}"
                                 alt="Card image cap ">
                            <div class="card-body">
                                <p class="card-text">{{$content->title}}</p>
                                <div class="action">
                                    <a href="{{route('edit-page-show-life-style',$content->id)}}" class="btn btn-primary">Edit</a>
                                    <a ONCLICK="deleteItem({{$content->id}})" class="btn btn-danger">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="tpagination mt-4">
                {{$contents->links()}}
            </div>
        </div>
        <input type="hidden"  value="{{env('APP_URL')}}" id="appUrl">
        {{--    ///////// modal --}}
        <div class="newmodal" id="popup" style="display: none">
            <div class="show">
                <div class="text-center popup">
                    <div class="message">
                        <h5>Do You Want To Delete This Item ?</h5>
                    </div>
                    <div class="d-flex justify-content-center submit mt-4">
                        <div>
                            <form action="" id="deleteFrom" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class=" btn btn-danger">Yes</button>
                            </form>

                        </div>
                        <div class="ml-4">
                            <button onClick="remove()" class=" btn btn-primary">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        const item = document.getElementById('message');
        setTimeout(function () {
            item.style.display = 'none'
        }, 5000);

        const appUrl = document.getElementById('appUrl').value;
        const popUp = document.getElementById('popup');

        function deleteItem($id)
        {
            const deleteFrom = document.getElementById('deleteFrom');
            popUp.style.display ='block';
            deleteFrom.action = appUrl+"/content/delete/"+$id;
        }
        function remove()
        {
            popUp.style.display ='none';
        }
    </script>
@endsection
