@extends('layouts.layout')
@section('content')
    <div class="p-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="header p-2">
                <h2>All Duas</h2>
            </div>
            <div class="addNew p-2">
                <a href="{{ route('dua.add-item') }}" class="btn btn-dark ml-2"><i class="mdi mr-2 mdi-plus"></i>Add
                    Dua</a>
                <a href="{{ route('dua.add') }}" class="btn btn-dark"><i class="mdi mr-2 mdi-plus"></i>Add
                    Category</a>
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
                        <li><a class="{{ (request()->is('dua')) ? 'active':'' }} mb-3"
                               href="{{route('dua')}}">All</a></li>
                        @forelse ($dua as $d)
                            <li><a href="{{route('dua.search',$d->id)}}"
                                   class="{{ (\Request::getRequestUri() == '/dua/'. $d->id ? 'active':'' )}} mb-3">{{$d->title}}</a>
                            </li>
                        @empty

                        @endforelse
                    </ul>
                </nav>
            </div>
            <div class="row mt-3">
                @forelse($content as $c)
                    <div class="col-lg-3 col-xl-3 col-md-3 col-sm-12">
                        <div class="card w-100">
                            <div class="tag p-2">
                                <p>{{$c->dua->title}}</p>
                            </div>
                            <img class="card-img-top w-100"
                                 src="{{$c->dua->image}}"
                                 alt="Card image cap ">

                            <div class="card-body">
                                <p class="card-text">{{$c->title}}</p>
                                <audio controls>
                                    <source src="{{$c->audio}}" type="audio/mpeg">
                                </audio>
                                <div class="action mt-2">
                                    <a href="{{route('dua.edit-item',$c->id)}}"
                                       class="btn btn-primary">Edit</a>
                                    <a ONCLICK="deleteItem({{$c->id}})" class="btn btn-danger">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-lg-3 col-xl-3 col-md-3 col-sm-12">
                        <div class="card w-100 py-4 text-center">
                            No data found
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="tpagination mt-4">
                {{$content->links()}}
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
                                    <form id="deleteFrom" method="post">
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
            // deleteFrom.action = appUrl+"/dua/delete/"+$id;
            deleteFrom.action = "{{ url()->current() }}/delete/" + $id;
        }
        function remove()
        {
            popUp.style.display ='none';
        }
    </script>
@endsection
