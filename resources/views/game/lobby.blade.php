@extends('master')

@section('title')
    Memoria
@endsection

@section('content')


    <transition>
        <keep-alive>
        	
            <router-view :user="loggedUser" :token="accessToken"></router-view>
            
        </keep-alive>
    </transition>
@endsection


@section('pagescript')
    <script>

        //esta variável guarda o token de reset que é mandado pela função reset no GameController
        var token = "{{ session()->get('token', 0) }}"
        
    </script>
@endsection
