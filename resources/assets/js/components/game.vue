<template>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div  class="panel-heading">Game {{game.gameID}} ({{game.name}}) - {{pending()}}</div>
                <div class="panel-body">
                    <div class="alert" :class="alerttype" v-if="this.game.winner">
                        <strong>{{ message }} &nbsp;&nbsp;&nbsp;&nbsp;<a v-on:click.prevent="closeGame">Close Game</a></strong>
                    </div>
                    <div v-if="canBot()">
                        <label for="bot">Bot Dificulty</label>
                        <select id="bot" v-model="bot">
                            <option value="1">Dumb Bot</option>
                            <option value="2">Medium Bot</option>
                            <option value="3">Smart Bot</option>
                        </select>
                        <button class="btn btn-sm btn-success" v-on:click="addBot">Add Bot</button>
                        <br>
                    </div>
                    <table class="table table-striped" style="text-align:center;">
                            <thead>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Turn</th>
                                <th>Score</th>
                                <th v-if="canKick()">Timeout</th>
                            </thead>
                            <tbody>
                                <tr v-bind:class="{ success: isTurn(key), danger: danger(key) }" v-for="(player, key) in game.players">
                                    <td>{{ player.id }}</td>
                                    <td>{{ player.name }}</td>
                                    <td>{{ isTurnString(key) }}</td>
                                    <td>{{ player.score }}</td>
                                    <td v-if="canKick()">{{ timeout(key) }}</td>
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
        props: ['game', 'user'],
        data: function(){
			return {
                alerttype:{
                    
                },
                currentTime: null,
                interval: null,
                bot: 1
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
            addBot(){
                this.$emit('add-bot', this.game.gameID, this.bot);
            },
            canBot(){
                let hasBot=false;
                for(let i =0; i<this.game.players.length; i++){
                    if(this.game.players[i].bot){
                        hasBot=true;
                        break;
                    }
                }
                return !this.game.gameStarted && !hasBot; //acrescentar condição de dono do jogo
            },
            canKick(){
                return this.game.gameSize > 1 && this.game.players.length > 1;
            },
            danger(key){
                return this.game.playerTurn == key+1 && this.game.lastPlay !== null && Math.ceil((this.game.lastPlay+29000 - this.currentTime) / 1000) <= 5;
            },
            newTime(){
                this.currentTime=new Date().getTime();
                if(this.game.lastPlay !== null && this.currentTime !== null && this.game.lastPlay+29000 - this.currentTime < 0){
                    clearInterval(this.interval);
                    this.interval=null;
                    this.$emit('kick-player', {gameId: this.game.gameID, player: this.game.players[this.game.playerTurn-1]});
                    console.log(this.game.players[this.game.playerTurn-1]);
                }
            },
            timeout(key){
                if(this.interval===null){
                    this.newTime();
                    this.interval=setInterval(this.newTime, 1000);
                }
                let time = this.game.playerTurn == key+1 && this.game.lastPlay !== null ? Math.ceil((this.game.lastPlay+29000 - this.currentTime) / 1000) : 30;
                if(time < 0){
                    return '0s';
                }
                return time + 's';
            },
            pending(){
                if(this.game.gameEnded){
                    return 'Ended';
                }
                return this.game.gameStarted ? 'Started' : 'Waiting Players ' + this.game.players.length + '/' + this.game.gameSize;
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
            clickPiece(index){
                this.$emit('piece-click', this.game.gameID, index);
            },
            pieceImageURL: function (piece) {
                return 'img/' + piece + '.png';
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