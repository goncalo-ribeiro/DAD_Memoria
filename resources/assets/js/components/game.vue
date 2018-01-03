<template>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div  class="panel-heading">Game {{game.gameID}}</div>
                <div class="panel-body">
                    <div class="alert" :class="alerttype">
                        <h2>Current Player: {{ game.playerTurn}}</h2>
                        <strong v-if="this.game.winner">{{ message }} &nbsp;&nbsp;&nbsp;&nbsp;<a v-on:click.prevent="closeGame">Close Game</a></strong>
                    </div>
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
                if(this.game.winner != '')
                    return 'Player ' + this.game.winner + ' has won!';
                return 'The game ended in a tie';
            },
        },
        methods: {
            newLine(key){
                return key%this.game.colunas === 0 && key !== 0;
            },
            player2(){
                if(this.game.player2 != "")
                    return true;
                return false;
            },
            closeGame (){
                this.$emit('close', this.game.gameID);
            },
            clickPiece(index){
                console.log(this.game.gameID);
                this.$emit('clicked-piece', this.game.gameID, index);
            },
            pieceImageURL: function (piece) {
                if(true || piece["show"]){
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