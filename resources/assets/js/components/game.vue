<template>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div  class="panel-heading">Game {{game.gameID}}</div>
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
                            </thead>
                            <tbody>
                                <tr v-bind:class="{ success: isTurn(player, key) }" v-for="(player, key) in game.players">
                                    <td>{{ player.id }}</td>
                                    <td>No name yet!</td>
                                    <td>{{ isTurnString(player, key) }}</td>
                                    <td>{{ player.score }}</td>
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
            message(){
                if(this.game.winner != ''){
                    return 'Winner: ' + this.game.winner;
                }
            },
        },
        methods: {
            gameEnded(){
                return this.game.gameEnded;
            },
            isTurn(player, key){
                return player.id === key+1;
            },
            isTurnString(player, key){
                return player.id === key+1 ? "True" : "False";
            },
            newLine(key){
                return key%this.game.colunas === 0 && key !== 0;
            },
            closeGame (){
                this.$emit('close', this.game.gameID);
            },
            clickPiece(index){
                console.log(index);
                this.$emit('piece-click', this.game.gameID, index);
            },
            pieceImageURL: function (piece) {
                if(piece["show"]){
                    var imgSrc = String(piece["piece"]);
                    return 'img/' + imgSrc + '.png';
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