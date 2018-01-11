<template>
    <div>
        <div class="container">
            <h3 class="text-center">{{ title }}</h3>
            <lobby :games="lobbyGames" @view="view" ></lobby>
            <template v-for="game in activeGames">
                <game :game="game" @close-game="closeGame"></game>
            </template>
        </div>
    </div>
</template>

<script type="text/javascript">
    import Lobby from './replayLobby.vue';
    import Game from './replayGame.vue';

    export default {
        data: function(){
            return {
                title: 'Replay de Jogos',
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
            disconnect(){
                console.log('socket disconnected');
                this.socketId = "";
            },
            replay_lobby_games_changed(data){
                this.lobbyGames=data.lobbyGames;
            },
            new_active_replay(data){
                Vue.set(this.activeGames, this.activeGames.length, data.game);
            }
        },        
        methods: {
            loadLobby(){
                this.$socket.emit('get_replay_lobby');
            },
            view(data){
                this.$socket.emit('watch_game', { gameId: data.gameId });
            },
            closeGame(game){
                for(let i=0; i<this.activeGames.length; i++){
                    if(this.activeGames[i].gameID===game){
                        this.activeGames.splice(i, 1);
                        break;
                    }
                }
            }
        },
        components: {
            'lobby': Lobby,
            'game': Game,
        },
        mounted() {
            this.loadLobby();
        },
        created() {
            this.loadLobby();
        },
        updated() {
            this.loadLobby();
        }
    }
</script>