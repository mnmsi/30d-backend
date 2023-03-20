@extends('layouts.layout')
@section('content')
    <div class="p-3 payment">
        <div class="d-flex justify-content-between align-items-center">
            <div class="header p-2">
                <h2>Payment History</h2>
            </div>
            <form action="{{route('payment-history.search')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('post')
                <div class="header p-2">
                    <div class="input-group mb-3">
                        <input type="text" name="search" class="form-control" placeholder="Name or Email">
                        <div class="input-group-append">
                            <input type="submit" class="input-group-text btn btn-primary">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- Card view for rules -->
        <div class="listOfContentType mt-4 card-view">
            <div class="row mt-4 pl-3">
                @foreach($data as $item)
                    <div class="col-lg-4 col-xl-4 col-md-4 col-sm-12 card-space">
                        <div class="card w-100">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="d-flex flex-column flex-fill w-100">
                                        <label class="card-title text-size font-weight-bold">{{ ($data ->currentpage()-1) * $data ->perpage() + $loop->index + 1 }}. {{$item->first_name }} {{ $item->last_name}}</label>
                                        <label class="card-subtitle mb-2 text-size">{{$item->email}}</label>
                                    </div>
                                </div>
                                <div class="flex-row d-flex justify-content-between">
                                    <label>Zakat</label>
                                    <label>{{$item->zakat}}</label>
                                </div>
                                <div class="flex-row d-flex justify-content-between">
                                    <label>Sadaqah</label>
                                    <label>{{$item->sadaqah}}</label>
                                </div>
                                <div class="flex-row d-flex justify-content-between">
                                    <label>Riba</label>
                                    <label>{{$item->riba}}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="tpagination mt-4">
                {{$data->links()}}
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
    </script>
@endsection
