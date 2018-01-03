<template>
	<div class="gameseparator">
        <div>
            <h2 class="text-center">Game {{game.gameID}}</h2>
            <br>
        </div>
        <div class="game-zone-content">       
            <div class="alert" :class="alerttype">
                <h2>Current Player: {{ game.player1}}</h2>
                <strong v-if="this.game.winner">{{ message }} &nbsp;&nbsp;&nbsp;&nbsp;<a v-on:click.prevent="closeGame">Close Game</a></strong>
            </div>
            <div class="board">
                <div v-for="(piece, key) of game.board" >
                    <img v-bind:src="pieceImageURL(piece)" v-on:click="clickPiece(key)">
                </div>
            </div>
            <hr>
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
                if(piece[show]){
                    var imgSrc = String(piece[piece]);
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