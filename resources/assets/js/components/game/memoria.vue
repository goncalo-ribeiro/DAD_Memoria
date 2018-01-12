<template>
    <div>
        <div class="container">
            <h3 class="text-center">{{ title }}</h3>
            <lobby :user="user" :chat="chat" :games="lobbyGames" @join-game="join" @create-click="createGame" @comment-sent="commentSent"></lobby>
            <template v-for="game in activeGames">
                <game :user="user" :game="game" @start="start" @piece-click="play" @close-game="closeGame" @kick-player="kickPlayer" @add-bot="addBot"></game>
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
                chat:[]
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
            },
            chat_entry(message){
                this.chat.push(message);
            }
        },        
        methods: {
            commentSent(message){
                this.$socket.emit('chat_message', message);
            },
            addBot(id, bot){
                this.$socket.emit('add_bot', {id: id, bot: bot});
            },
            start(id, player){
                this.$socket.emit('start', {id: id, player: player});
            },
            kickPlayer(data){
                this.$socket.emit('kick_player', data);
            },
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
                    playerId: this.user.id,
                    playerName: this.user.nickname,
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
        props: {
            user: Object,
        },
        mounted() {
            this.loadLobby();
        }
    }
</script>