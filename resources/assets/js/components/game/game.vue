<template>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div  class="panel-heading">Game {{game.gameID}} {{gameName()}} - {{pending()}}</div>
                <div class="panel-body">
                    <a v-if="canStart()" v-on:click.prevent="start">Start Game</a>
                    <div class="alert" :class="alerttype" v-if="this.game.winner">
                        <strong>{{ message }} &nbsp;&nbsp;&nbsp;&nbsp;<a v-on:click.prevent="closeGame">Close Game</a></strong>
                    </div>
                    <div v-if="canBot()">
                        <label class="inline" for="bot">Bot Dificulty:</label>
                        <span>Easy</span>        
                        <input type="range" min="0" max="100" class="slider inline" id="bot" v-model="bot">
                        <span>Very Hard</span>
                        <input @change="limit" type="number" min="0" max="100" class="inline" v-model="bot">
                        <input type="text" readonly value="%" class="inline unit"/> 
                        <button class="btn btn-sm btn-success inline" v-on:click="addBot">Add Bot</button>
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
                bot: 50
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
            limit(){
                if(this.bot < 0){
                    this.bot=0;
                }else if(this.bot > 100){
                    this.bot=100;
                }
            },
            gameName(){
                if(this.game.name !== ''){
                    return '(' + this.game.name + ')';
                }
                return '';
            },
            addBot(){
                this.$emit('add-bot', this.game.gameID, this.bot/100);
            },
            canBot(){
                return !this.game.gameStarted && !this.game.hasBot && this.user.id == this.game.players[0].id;
            },
            canStart(){
                return !this.game.gameStarted && this.user.id == this.game.players[0].id;
            },
            start(){
                this.$emit('start', this.game.gameID, this.user.id);
            },
            canKick(){
                return this.game.gameSize > 1 && this.game.players.length > 1 && !this.onlyBots();
            },
            onlyBots(){
                for(let i=1; i<this.game.players.length; i++){
                    if(!this.game.players[i].bot){
                        return false;
                    }
                }
                return true;
            },
            danger(key){
                return this.game.playerTurn == key+1 && this.game.lastPlay !== null && Math.ceil((this.game.lastPlay+29000 - this.currentTime) / 1000) <= 5 && !this.game.gameEnded;
            },
            newTime(){
                this.currentTime=new Date().getTime();
                if(this.game.gameEnded){
                    clearInterval(this.interval);
                    this.interval=null;
                }
                else if(this.game.lastPlay && this.currentTime && this.game.lastPlay+29000 - this.currentTime < 0){
                    clearInterval(this.interval);
                    this.interval=null;
                    this.$emit('kick-player', {gameId: this.game.gameID, player: this.game.players[this.game.playerTurn-1]});
                }
            },
            timeout(key){
                if(this.interval===null){
                    this.newTime();
                    this.interval=setInterval(this.newTime, 1000);
                }
                let time = this.game.playerTurn == key+1 && this.game.lastPlay !== null && !this.game.gameEnded ? Math.ceil((this.game.lastPlay+29000 - this.currentTime) / 1000) : 30;
                if(time < 0){
                    return 'Kicked';
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
.inline{
    display: inline-block;
}
.slider {
    -webkit-appearance: none;
    width: 40%;
    height: 10px;
    border-radius: 5px;   
    background: #d3d3d3;
    outline: none;
    opacity: 0.7;
    -webkit-transition: .2s;
    transition: opacity .2s;
}
.slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 15px;
    height: 15px;
    border-radius: 50%; 
    background: #4CAF50;
    cursor: pointer;
}
.slider::-moz-range-thumb {
    width: 15px;
    height: 15px;
    border-radius: 50%;
    background: #4CAF50;
    cursor: pointer;
}
.unit{
    border: none;
    border-color: transparent;
    width: 15px;
}
</style>