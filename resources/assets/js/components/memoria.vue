<template>
    <div>
        <div class="container">
            <h3 class="text-center">{{ title }}</h3>
            <lobby :games="lobbyGames" @join-game="join" @create-click="createGame"></lobby>
            <template v-for="game in activeGames">
                <game :game="game" @piece-click="play" @close-game="closeGame"></game>
            </template>
        </div>
    </div>
</template>

<script type="text/javascript">
    import Lobby from './lobby.vue';
    import Game from './game.vue';

    export default {
        data: function(){
            return {
                title: 'Jogo da Memória',
                lobbyGames: [],
                activeGames: [],
                socketId: "",
            }
        },
        sockets:{
            connect(){
                console.log('socket connected');
                this.socketId = this.$socket.id;
            },
            discconnect(){
                console.log('socket disconnected');
                this.socketId = "";
            },
            my_active_games_changed(){
                this.loadActiveGames();
            },
            lobby_changed(){
                this.loadLobby();
            },
            lobby_games_changed(data){
                this.lobbyGames=data.lobbyGames;
            },
            active_games_changed(data){
                this.activeGames=data.activeGames;
                console.log(data.activeGames);
            }
        },        
        methods: {
            loadLobby(){
                this.$socket.emit('get_games_lobby');
            },
            loadActiveGames(){
                this.$socket.emit('get_active_games');
            },
            createGame(data){
                this.$socket.emit('create_game', data);   
            },
            join(data){
                this.$socket.emit('join_game', { 
                    playerId: 2,
                    playerName: 'Rick Sanchez',
                    gameId: data.gameId
                 });
            },
            play(id, index){
                this.$socket.emit('play', {id: id, index: index});
            },
            closeGame(game){
                this.$socket.emit('close', {id: game});
            }
        },
        components: {
            'lobby': Lobby,
            'game': Game,
        },
        mounted() {
            this.loadLobby();
        }
    }
</script>