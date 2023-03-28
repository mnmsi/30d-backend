@extends('layouts.layout')
@section('content')
    <div class="row p-4 homeDash">
        <div class="col-xl-4 col-md-4 col-lg-4 col-sm-12 mb-3">
            <a href="{{route('life-style')}}">
                <div class="cardBox d-flex justify-content-between">
                    <div>
                        <h5>Life Style</h5>
                        <p class="mt-4">Total Post : <span>{{$life ?? 0}}</span> </p>
                    </div>
                    <i class="mdi mr-2 mdi-account-check"></i>
                </div>
            </a>
        </div>
        <div class="col-xl-4 col-md-4 col-lg-4 col-sm-12 mb-3">
            <a href="{{route('educatie')}}">
                <div class="cardBox d-flex justify-content-between">
                    <div>
                        <h5>Education</h5>
                        <p class="mt-4">Total Post : <span>{{$educate ?? 0}}</span> </p>
                    </div>
                    <i class="mdi mr-2 mdi-school"></i>
                </div>
            </a>
        </div>
        <div class="col-xl-4 col-md-4 col-lg-4 col-sm-12 mb-3">
            <a href="{{route('hadith')}}">
                <div class="cardBox d-flex justify-content-between">
                    <div>
                        <h5>Hadith</h5>
                        <p class="mt-4">Total Post : <span>{{$hadith ?? 0}}</span> </p>
                    </div>
                    <i class="mdi mr-2 mdi-book-open-variant"></i>
                </div>
            </a>
        </div>
        <div class="col-xl-4 col-md-4 col-lg-4 col-sm-12 mb-3">
            <a href="{{route('newsPortal')}}">
                <div class="cardBox  d-flex justify-content-between">
                    <div>
                        <h5>News Portal</h5>
                        <p class="mt-4">Total Post : <span>{{$news ?? 0}}</span> </p>
                    </div>
                    <i class="mdi mr-2 mdi-note-multiple-outline"></i>
                </div>
            </a>
        </div>
        <div class="col-xl-4 col-md-4 col-lg-4 col-sm-12 mb-3">
            <a href="{{route('rules')}}">
                <div class="cardBox  d-flex justify-content-between  align-items-center">
                    <div>
                        <h5>Rules</h5>
                        <p class="mt-4">Total Post : <span>{{$rules ?? 0}}</span> </p>
                    </div>
                    <i class="fas mr-2 fa-shield-alt"></i>
                </div>
            </a>
        </div>
        <div class="col-xl-4 col-md-4 col-lg-4 col-sm-12 mb-3">
            <a href="{{route('payment-history')}}">
                <div class="cardBox  d-flex justify-content-between  align-items-center">
                    <div>
                        <h5>Payment History</h5>
                        <p class="mt-4">Total Payment : <span>{{$payment ?? 0}}</span> </p>
                    </div>
                    <i class="fas mr-2 fa-hand-holding-usd"></i>
                </div>
            </a>
        </div>
        <div class="col-xl-4 col-md-4 col-lg-4 col-sm-12 mb-3">
            <a href="{{route('dua')}}">
                <div class="cardBox  d-flex justify-content-between  align-items-center">
                    <div>
                        <h5>Dua</h5>
                        <p class="mt-4">Total Dua : <span>{{$dua ?? 0}}</span> </p>
                    </div>
                    <i class="fas mr-2 fa-sticky-note"></i>
                </div>
            </a>
        </div>

    </div>
@endsection
