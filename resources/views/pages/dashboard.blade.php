@extends('layouts.layout')
@section('content')
<div class="row p-4">

    <div class="col-xl-4 col-md-4 col-lg-4 col-sm-12 mb-3">
        <a href="{{route('life-style')}}">
            <div class="cardBox">
                <h5>Life Style</h5>
                <p class="mt-4">Total Post : <span>250</span> </p>
            </div>
        </a>
    </div>
    <!-- Column -->
    <div class="col-lg-8 col-md-7">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex flex-wrap align-items-center">
                            <div>
                                <h3 class="card-title">Sales Overview</h3>
                                <h6 class="card-subtitle">Ample Admin Vs Pixel Admin</h6>
                            </div>
                            <div class="ml-lg-auto mx-sm-auto mx-lg-0">
                                <ul class="list-inline d-flex">
                                    <li class="mr-4">
                                        <h6 class="text-success"><i
                                                class="fa fa-circle font-10 m-r-10 "></i>Ample</h6>
                                    </li>
                                    <li>
                                        <h6 class="text-info"><i
                                                class="fa fa-circle font-10 m-r-10"></i>Pixel</h6>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="amp-pxl" style="height: 360px;">
                            <div class="chartist-tooltip"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-5">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Our Visitors </h3>
                <h6 class="card-subtitle">Different Devices Used to Visit</h6>
                <div id="visitor"
                    style="height: 290px; width: 100%; max-height: 290px; position: relative;"
                    class="c3">
                    <div class="c3-tooltip-container"
                        style="position: absolute; pointer-events: none; display: none;">
                    </div>
                </div>
            </div>
            <div>
                <hr class="m-t-0 m-b-0">
            </div>
            <div class="card-body text-center ">
                <ul class="list-inline d-flex justify-content-center align-items-center mb-0">
                    <li class="mr-4">
                        <h6 class="text-info"><i class="fa fa-circle font-10 mr-2 "></i>Mobile</h6>
                    </li>
                    <li class="mr-4">
                        <h6 class=" text-primary"><i class="fa fa-circle font-10 mr-2"></i>Desktop</h6>
                    </li>
                    <li class="mr-4">
                        <h6 class=" text-success"><i class="fa fa-circle font-10 mr-2"></i>Tablet</h6>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
