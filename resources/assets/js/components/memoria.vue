<template>
    <div>
        <div class="container">
            <h3 class="text-center">{{ title }}</h3>
            <lobby :games="lobbyGames" @join-click="join"></lobby>
            <!--
            <template v-for="game in activeGames">
                <game :game="game" @piece-click="play" @close-game="close"></game>
            </template>
            -->
        </div>
    </div>
</template>

<script type="text/javascript">
    import Lobby from './lobby.vue';

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

        },
        methods: {
            join(){

            }
        },
        components: {
            'lobby': Lobby,
            //'game': GameTicTocToe,
        },
        mounted() {
            //this.loadLobby();
        }
    }
</script>