<template>
    <div class="container">
        <div class="row">
            <div class="panel-body">
                <div class="col-sm-6"><TotalGames></TotalGames></div>
                <div class="col-sm-3"><ListTopPlayers></ListTopPlayers></div>
        
                <!--We cant use blade-->
                <!--more info here: https://stackoverflow.com/questions/42951976/how-can-i-use-auth-on-vue-component-vue-js-2-->
                <div>
                    <UserStatistics></UserStatistics>
                </div>
                
                
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    "use strict";
    import TotalGames from './statistics/TotalGames.vue';
    import ListTopPlayers from './statistics/ListTopPlayers.vue';

    import UserStatistics from './statistics/UserStatistics.vue';

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