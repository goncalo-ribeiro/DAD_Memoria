@extends('master')

@section('content')
    <transition>
        <keep-alive>
        	
            <router-view></router-view>
            
        </keep-alive>
    </transition>
@endsection
