<template>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div  class="panel-heading">Game {{game.gameID}} - {{pending()}}</div>
                <div class="panel-body">
                    <div class="alert" :class="alerttype">
                        <strong v-if="this.game.winner">{{ message }} &nbsp;&nbsp;&nbsp;&nbsp;<a v-on:click.prevent="closeGame">Close Game</a></strong>
                    </div>
                    <table class="table table-striped" style="text-align:center;">
                            <thead>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Turn</th>
                                <th>Score</th>
                                <th>Timeout</th>
                            </thead>
                            <tbody>
                                <tr v-bind:class="{ success: isTurn(key) }" v-for="(player, key) in game.players">
                                    <td>{{ player.id }}</td>
                                    <td>{{ player.name }}</td>
                                    <td>{{ isTurnString(key) }}</td>
                                    <td>{{ player.score }}</td>
                                    <td>{{ timeout }}</td>
                                </tr>
                            </tbody>
                    </table>
                    <div class="board" style="text-align:center">
                        <span v-for="(piece, key) of game.board">
                            <br v-if="newLine(key)">
                            <img v-bind:src="pieceImageURL(piece)" v-on:click="clickPiece(key)" style="width:9.5%">
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>		
</template>

<script type="text/javascript">
	export default {
        props: ['game'],
        data: function(){
			return {
                alerttype:{
                    
                }
            }
        },
        computed: {
            timeout(){
                return this.game.lastPlay !== null ? Math.ceil((this.game.lastPlay+30000 - new Date().getTime()) / 1000) + 's' : '30s';
            },
            message(){
                if(this.game.winner != ''){
                    return 'Winner: ' + this.game.winner;
                }
            },
        },
        methods: {
            pending(){
                if(this.game.gameEnded){
                    return 'Ended';
                }
                return this.game.gameStarted ? 'Started' : 'Waiting Players ' + this.game.players.length + '/' + this.game.gameSize;
            },
            gameEnded(){
                return this.game.gameEnded;
            },
            isTurn(key){
                return this.game.playerTurn === key+1;
            },
            isTurnString(key){
                return this.game.playerTurn === key+1 ? 'True' : 'False';
            },
            newLine(key){
                return key%this.game.colunas === 0 && key !== 0;
            },
            closeGame (){
                this.$emit('close-game', this.game.gameID);
            },
            clickPiece(index){
                this.$emit('piece-click', this.game.gameID, index);
            },
            pieceImageURL: function (piece) {
                if(piece.show){
                    return 'img/' + piece.piece + '.png';
                }else{
                    return 'img/hidden.png';
                }
            }
        },
    }
</script>

<style scoped>	
.gameseparator{
    border-style: solid;
    border-width: 2px 0 0 0;
    border-color: black;
}
</style>