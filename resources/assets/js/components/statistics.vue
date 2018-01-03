<template>
    <div class="container">
        <div class="row">
            <div class="panel-body">
                <TotalGames></TotalGames>
                <ListTopPlayers></ListTopPlayers>
                <UserStatistics></UserStatistics>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    "use strict";
    import TotalGames from './statistics/totalGames.vue';
    import ListTopPlayers from './statistics/listTopPlayers.vue';

    import UserStatistics from './statistics/userStatistics.vue';

    export default {
        data: function(){
            return {
                title: 'Jogo da Memória',
                globalStatistics: [],
                topPlayers: [],
                UserStatistics: []
            }
        },
        sockets:{

        },
        methods: {
            join(){

            }
        },
        components: {
            'TotalGames': TotalGames,
            'ListTopPlayers': ListTopPlayers,
            'UserStatistics': UserStatistics
        },
        mounted() {
            //goona retrieve data later!...Why;_;)
            //why axious why;_;
        }   
    }
</script>