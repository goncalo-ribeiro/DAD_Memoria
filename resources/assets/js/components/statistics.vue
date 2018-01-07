<template>
    <div class="container">
        <div class="row">
            <div class="panel-body">
                <div class="col-sm-6"><TotalGames :totalGames="globalStatistics"></TotalGames></div>
                <div class="col-sm-3"><ListTopPlayers :players="topPlayers"></ListTopPlayers></div>
        
                <!--We cant use blade-->
                <!--more info here: https://stackoverflow.com/questions/42951976/how-can-i-use-auth-on-vue-component-vue-js-2-->
                <div>
                    <UserStatistics></UserStatistics>
                </div>
                
                <user          
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
                globalStatistics: [],
                topPlayers: [],
                UserStatistics: []
            }
        },
        sockets:{

        },
        methods: {
            join(){

            },
            
        },
        components: {
            'TotalGames': TotalGames,
            'ListTopPlayers': ListTopPlayers,
            'UserStatistics': UserStatistics
        },
        mounted() {

            //Retrieves the data for the listTopPlayers component
            axios({method: 'get',
                    url: '/api/topplayers',
                    headers: {
                        'Accept' : 'application/json',
                        //'Authorization': 'Bearer ' + this.$root.$data['accessToken']
                    }
                }).then(response=>{
                    this.topPlayers = response.data; 
                });




            //Retrieves the data for the totalGames component
            axios({method: 'get',
                    url: '/api/totalgames',
                    headers: {
                        'Accept' : 'application/json',
                        //'Authorization': 'Bearer ' + this.$root.$data['accessToken']
                    }
                }).then(response=>{
                    this.globalStatistics = response.data;
                    this.$emit('loadGlobal', response.data);
                });            
        }   
    }
</script>