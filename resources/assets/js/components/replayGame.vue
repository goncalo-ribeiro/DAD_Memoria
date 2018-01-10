<template>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div  class="panel-heading">Game {{game.gameID}} ({{game.name}})</div>
                <div class="panel-body">
                    <div class="alert" :class="alerttype">
                        <a v-if="!this.game.gameEnded" v-on:click.prevent="start">Start</a>
                        <strong v-if="this.game.gameEnded">{{ message }} &nbsp;&nbsp;&nbsp;&nbsp;<a v-on:click.prevent="closeGame">Close Game</a></strong>
                    </div>
                    <table class="table table-striped" style="text-align:center;">
                            <thead>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Turn</th>
                                <th>Score</th>
                            </thead>
                            <tbody>
                                <tr v-bind:class="{ success: isTurn(key) }" v-for="(player, key) in game.players">
                                    <td>{{ player.id }}</td>
                                    <td>{{ player.name }}</td>
                                    <td>{{ isTurnString(key) }}</td>
                                    <td>{{ player.score }}</td>
                                </tr>
                            </tbody>
                    </table>
                    <div class="board" style="text-align:center">
                        <span v-for="(piece, key) of game.board">
                            <br v-if="newLine(key)">
                            <img v-bind:src="pieceImageURL(piece)" style="width:9.5%">
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
                    
                },
                interval: null,
                currAction: 0,
                firstPiece: null,
                secondPiece: null,
            }
        },
        computed: {
            message(){
                if(this.game.winner != ''){
                    return 'Winner: ' + this.game.winner;
                }
            },
        },
        methods: {
            start(){
                this.game.gameStarted=true;
                this.interval=setInterval(this.makeMove, 1000);
            },
            gameEnded(){
                if(this.game.gameEnded){
                    clearInterval(this.interval);
                    this.interval=null;
                }
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
            pieceImageURL: function (piece) {
                if(piece.show){
                    return 'img/' + piece.piece + '.png';
                }else{
                    return 'img/hidden.png';
                }
            },
            makeMove(){
                if(this.currAction >= this.game.actions.length){
                    clearInterval(this.interval);
                    this.interval=null;
                }
                if(this.game.actions[this.currAction]===-1){
                    this.currAction++;
                    this.kickPlayer(this.game.actions[this.currAction]);
                    this.currAction++;
                }else{
                    this.revealPiece(this.game.actions[this.currAction]);
                    this.currAction++;
                    if(this.revealPiece(this.game.actions[this.currAction]) !== 1){
                        setTimeout(this.hidePieces, 1000);
                    }
                    this.currAction++;
                }
            },
            revealPiece(index){
                Vue.set(this.game.board[index], "show", true);
                if(this.firstPiece===null){
                    this.firstPiece=index;
                    return 0;
                }else{
                    if(this.game.board[this.firstPiece].piece === this.game.board[index].piece){
                        this.firstPiece=null;
                        this.game.players[this.game.playerTurn-1].score++;
                        if(this.noMorePieces()){
                            this.game.gameEnded=true;
                        }
                        return 1;
                    }
                    this.secondPiece=index;
                    return -1;
                }
            },
            hidePieces(){
                Vue.set(this.game.board[this.firstPiece], "show", false);
                Vue.set(this.game.board[this.secondPiece], "show", false);
                this.firstPiece=null;
                this.secondPiece=null;
                this.nextPlayer();
            },
            nextPlayer(){
                this.game.playerTurn++;
                if(this.game.playerTurn > this.game.players.length){
                    this.game.playerTurn=1;
                }
            },
            noMorePieces(){
                for(let i = 0; i < this.game.board.length; i++){
                    if(!this.game.board[i].show){
                        return false;
                    }
                }
                return true;
            },
            kickPlayer(key){
                this.game.players.splice(key, 1);
                this.game.playerTurn--;
                if(this.game.players.length==1){
                    this.game.gameEnded=true;
                }
                this.nextPlayer();
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