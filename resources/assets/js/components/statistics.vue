<template>
    <div class="container">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6 col-xs-offset-1">
                        <TotalGames/>
                    </div>
                    <div class="col-sm-4 col-xs-offset-1">
                        <ListTopPlayers :players="globalStatistics.topPlayers"/>
                    </div>
                </div>
                <div class="row">
                     <div class="col-sm-4 col-xs-offset-1">
                       <UserVictorys></UserVictorys>
                    </div>
                    <div class="col-sm-6 col-xs-offset-1">
                      <UserGames></UserGames>
                    </div>
                </div>
                <div class="row">
                     <div class="col-sm-8 col-xs-offset-2">
                       <UserVictorys></UserVictorys>
                    </div>
                </div>
            </div>
                <!--We cant use blade-->
                <!--more info here: https://stackoverflow.com/questions/42951976/how-can-i-use-auth-on-vue-component-vue-js-2-->
        
    </div>
</template>

<script type="text/javascript">
    "use strict";
    import TotalGames from './statistics/totalGames.vue';
    import ListTopPlayers from './statistics/listTopPlayers.vue';
    import UserGames from './statistics/UserGames.vue';
    import UserVictorys from './statistics/UserVictorys.vue';


    export default {
        data: function(){
            return {
                globalStatistics: [],
                userStatistics: []
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
            'UserGames': UserGames,
            'UserVictorys': UserVictorys
        },
        mounted() {

            //Retrieves all the General Data and distributes it for all the respective components
            axios({method: 'get',
                    url: '/api/statistics/',
                    headers: {
                        'Accept' : 'application/json',
                        //'Authorization': 'Bearer ' + this.$root.$data['accessToken']
                    }
                }).then(response=>{
                    this.globalStatistics = response.data;
                    this.$emit('loadGlobalStatistics', this.globalStatistics.totalGames);
                });


            //Retrieves the data for the UserStatistics component
            axios({method: 'get',
                    url: '/api/statistics/user/32',
                    headers: {
                        'Accept' : 'application/json',
                        //'Authorization': 'Bearer ' + this.$root.$data['accessToken']
                    }
                }).then(response=>{
                    this.userStatistics = response.data;
                    this.$emit('loadUserGames', this.userStatistics.victorys);
                    this.$emit('loadUserVictorys', this.userStatistics.totalGames);
                    //
                });           
        }   
    }
</script>