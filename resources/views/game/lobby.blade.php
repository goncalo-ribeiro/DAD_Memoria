@extends('master')

@section('content')


    <transition>
        <keep-alive>
        	
            <router-view></router-view>
            
        </keep-alive>
    </transition>
@endsection


@section('pagescript')
    <script>
        
        @if(isset($token))
            var token = "{{ $token }}";
            console.log(token);
        @else
            var token = 0;
        @endif
        
    </script>
@endsection
