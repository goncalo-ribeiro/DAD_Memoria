<template>
    <div class="container">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6 col-xs-offset-1">
                        <TotalGames :games="globalStatistics.totalGames"/>
                    </div>
                    <div class="col-sm-4 col-xs-offset-1">
                        <ListTopPlayers :players="globalStatistics.topPlayers"/>
                    </div>
                </div>

                <div class="row" v-if="this.$root.$data['admin']">
                     <div v-if="this.$root.$data['admin']" >
                        <ListUsers></ListUsers>
                    </div>
                </div>

                <!--Check if user is logged in-->
                <div class="row" v-else-if="loggedUser">
                    <div class="col-sm-4 col-xs-offset-1">
                       	<UserVictorys :victorys="userStatistics.victorys"></UserVictorys>
                    </div>
                    <div class="col-sm-6 col-xs-offset-1">
                      	<UserGames :games="userStatistics.totalGames"></UserGames>	
                    </div>
                </div>
            </div>
    </div>
</template>

<script type="text/javascript">
    "use strict";
    import TotalGames from './statistics/totalGames.vue';
    import ListTopPlayers from './statistics/listTopPlayers.vue';
    import UserGames from './statistics/userGames.vue';
    import UserVictorys from './statistics/userVictorys.vue';
    import ListUsers from './statistics/listUsers.vue';

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
            'UserVictorys': UserVictorys,
            'ListUsers': ListUsers
        },
        computed: {
        	//Check if User is Logged and if is gets his Statistics
            loggedUser: function () {
            	if(this.$root.$data['loggedIn']==true && this.$root.$data['loggedUser']!=null){

            	 //Retrieves the User Data based on user ID and distributes it for all the respective components
                    axios({method: 'get',
                        url: '/api/statistics/user/'+this.$root.$data['loggedUser'].id,
                        headers: {
                            'Accept' : 'application/json',
                            //'Authorization': 'Bearer ' + this.$root.$data['accessToken']
                        }
                    }).then(response=>{
                        this.userStatistics = response.data;
                    }); 

                }else return this.$root.$data['loggedIn'];
                   
                return this.$root.$data['loggedIn'];
            }
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
                });                   
        }   
    }
</script>