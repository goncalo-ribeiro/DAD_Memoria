@extends('master')

@section('content')
	<div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Game Lobby</div>
                    <div class="panel-body">
                    	<div class="col-xs-10">
                    		<table class="table table-striped" style="text-align:center;">
                    			<thead>
                    				<th>ID</th>
                    				<th>Players</th>
                    				<th>Created By</th>
                    				<th>Created At</th>
                    			</thead>
                                <tbody>
                        			@foreach($games as $game)
                        				<tr>
                                            <td>{{$game->id}}</td>
                                            <td>{{count($game->users)}}/{{$game->total_players}}</td>
                                            <td>{{$game->owner->nickname}}</td>
                                            <td>{{$game->created_at}}</td>
                        				</tr>
                        			@endforeach
                                </tbody>
                    		</table>
                    	</div>
                    	<div class="col-xs-2">
                    		<button class="btn btn-success">Novo Jogo</button>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
