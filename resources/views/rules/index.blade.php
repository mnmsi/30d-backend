@extends('layouts.layout')
@section('content')
    <div class="p-3 rules">
        <div class="d-flex justify-content-between align-items-center">
            <div class="header p-2">
                <h2>Rules</h2>
            </div>
            <div class="addNew p-2">
                {{--      rules will be added          --}}
                <a href="{{ route('rules.create') }}" class="btn btn-dark"><i class="mdi mr-2 mdi-plus"></i>Add Rules</a>
            </div>
        </div>
        @if(session()->has('message'))
            <div class="alert alert-success w-100 mt-2 mb-2" id="message">
                {{ session()->get('message') }}
            </div>
        @endif
        <div class="mt-4 card-view">
            <div class="listOfContentType mt-3">
                <div class="PillButton">
                    <nav>
                        <ul class="p-0">
                            <li><a class="{{ (request()->is('rules')) ? 'active':'' }} mb-3"
                                   href="{{route('rules')}}">All</a></li>
                            <li><a href="{{route('rules.specific-items','Ramdan Quiz')}}"  class="{{ (\Request::getRequestUri() == '/rules/quiz-items/Ramdan%20Quiz' ? 'active':'' )}} mb-3">Ramdan Quiz</a></li>
                            <li><a href="{{route('rules.specific-items','Group Quiz')}}"  class="{{ (\Request::getRequestUri() == '/rules/quiz-items/Group%20Quiz' ? 'active':'' )}} mb-3">Group Quiz</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Card view for rules -->
            <div class="listOfContentType mt-4">
                <div class="row mt-4 pl-3">
                    @foreach($rules as $item)
                        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-12 card-space">
                            <div class="card w-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex flex-column card-responsive">
                                            <label class="card-title text-size font-weight-bold">{{ ($rules ->currentpage()-1) * $rules ->perpage() + $loop->index + 1 }}. {!!  \Illuminate\Support\str::limit(strip_tags($item->title), $limit = 10, $end = '...') !!}</label>
                                            <label class="card-subtitle mb-2 text-size">{{ $item->categoryType['category_name'] }}</label>
                                        </div>
                                        <div class="d-flex">
                                            <form action="{{route('rules.status',$item->id)}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                @method('put')
                                                <button type="submit" class="btn {{$item->status == 1 ? 'rules-active' : 'rules-deactive'}}">{{ $item->status == 1 ? 'ACTIVE' : 'DEACTIVE' }}</button>
                                            </form>
                                        </div>
                                        <div class="action flex-row d-flex">
                                            <a href="{{route('rules.edit', $item->id)}}" class="pr-3"><img src="{{ asset('/img/edit.svg') }}" class="logo-size"/></a>
                                            <a onclick="deleteItem({{$item->id}})"><img src="{{ asset('/img/delete.svg') }}" class="logo-size"/></a>
                                        </div>
                                    </div>
                                    <p class="card-block pt-1 card-text">{!!  \Illuminate\Support\str::limit(strip_tags($item->description), $limit = 150, $end = '...') !!}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="tpagination mt-4">
                    {{$rules->links()}}
                </div>
            </div>
        </div>
        {{--    ///////// modal for delete --}}
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
    </div>

@endsection
@section('script')
    <script>
        const item = document.getElementById('message');
        setTimeout(function () {
            item.style.display = 'none'
        }, 5000);

        const appUrl = document.getElementById('appUrl').value;


        function deleteItem($id)
        {
            const popUp = document.getElementById('popup');
            const deleteFrom = document.getElementById('deleteFrom');
            popUp.style.display ='block';
            // deleteFrom.action = appUrl+"/news-portal/delete/"+$id;
            deleteFrom.action = "{{ url()->current() }}/delete/"+ $id;
        }

        function remove()
        {
            const popUp = document.getElementById('popup');
            popUp.style.display ='none';
        }
    </script>
@endsection
