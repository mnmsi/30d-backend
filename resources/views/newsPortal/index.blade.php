@extends('layouts.layout')
@section('content')
    <div class="p-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="header p-2">
                <h2>News Portal</h2>
            </div>
            <div class="addNew p-2">
{{--                <a href="{{ route('educatie.create') }}" class="btn btn-primary mr-3"><i--}}
{{--                        class="mdi mr-2 mdi-plus"></i>Add Category</a>--}}
                <a href="{{ route('newsPortal.create') }}" class="btn btn-dark"><i class="mdi mr-2 mdi-plus"></i>Add News</a>
            </div>
        </div>
        @if(session()->has('message'))
            <div class="alert alert-success w-100 mt-2 mb-2" id="message">
                {{ session()->get('message') }}
            </div>
        @endif
        <div class="listOfContentType mt-3">

            <div class="row mt-3">
                @foreach($news as $item)
                    <div class="col-lg-3 col-xl-3 col-md-3 col-sm-12">
                        <div class="card w-100">
                            <img class="card-img-top w-100"
                                 src="{{asset('storage/'.$item->featured_image)}}"
                                 alt="Card image cap ">
                            <div class="card-body">
                                <p class="card-text">{{$item->title}}</p>
                                <p class="card-blockquote">{{$item->short_description}}</p>
                                <div class="action">
                                    <a href="{{route('newsPortal.edit', $item->id)}}" class="btn btn-primary">Edit</a>
                                    <a onclick="deleteItem({{$item->id}})" class="btn btn-danger">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="tpagination mt-4">
                {{$news->links()}}
            </div>
        </div>
        <input type="hidden"  value="{{env('APP_URL')}}" id="appUrl">
        {{--    ///////// modal --}}

    </div>
    <div class="newmodal" id="popup" style="display: none">
        <div class="show">
            <div class="text-center popup">
                <div class="message">
                    <h5>Do You Want To Delete This Item ?</h5>
                </div>
                <div class="d-flex justify-content-center submit mt-4">
                    <div>
                        <form id="deleteFrom" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Yes</button>
                        </form>

                    </div>
                    <div class="ml-4">
                        <button onClick="remove()" class=" btn btn-primary">No</button>
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
            //console.log('Hi :' +$id);
            const deleteFrom = document.getElementById('deleteFrom');
            popUp.style.display ='block';
            // deleteFrom.action = appUrl+"/news-portal/delete/"+$id;
            deleteFrom.action = "{{ url()->current() }}/delete/"+ $id;
        }

        function remove()
        {
            popUp.style.display ='none';
        }
    </script>
@endsection
