@extends('master')

@section('content')
    <transition name="slide-fade">
        <keep-alive>
            <router-view></router-view>
        </keep-alive>
    </transition>
@endsection
