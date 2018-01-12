<template>
    <div class="container">
        <div class="jumbotron">
            <h1 style="display: inline-block;">Utilizadores</h1>
            <img align="right" src="img/refresh.png" v-on:click="getUsers(key)" style="max-width: 35px; cursor: pointer; vertical-align:middle;">
        </div>
        
        <div v-if="typeof users !== 'undefined' && users.length > 0">
        <vue-good-table
          :columns="columns"
          :rows="users"
          :lineNumbers="true"
          :defaultSortBy="{field: 'nickname', type: 'asc'}"
          :globalSearch="true"
          :paginate="true"
          styleClass="table condensed table-bordered table-striped">
          <template slot="table-row" slot-scope="user">
            <td>{{ user.row.nickname }}</td>
            <td class="fancy">{{ user.row.email }}</td>
            <td>{{ user.row.name }}</td>
            <td><button class="btn btn-xs btn-success" data-toggle="modal" data-target="#modalUsersStatistics" v-on:click="getUserStatistics(user.row)">Detalhes</button></td>
          </template>
        </vue-good-table>


         <!-- Modal Block -->
        <div class="modal fade" id="modalUsersStatistics" tabindex="-1" role="dialog" 
             aria-labelledby="myModalLabel" aria-hidden="true">
            <div v-if="user!=null" class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <button type="button" class="close" 
                           data-dismiss="modal">
                               <span aria-hidden="true">&times;</span>
                               <span class="sr-only">Fechar</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            Utilizador: {{user.nickname}}
                        </h4>
                    </div>
                    
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4 col-xs-offset-1">
                                    <UserVictorys :victorys="selectedUser.victorys"></UserVictorys>
                                </div>
                                <div class="col-sm-6 col-xs-offset-1">
                                    <UserGames :games="selectedUser.totalGames"></UserGames>  
                                </div>
                            </div>
                        </div>                          
                    </div>
                    
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button id="closeModalBlock" type="button" class="btn btn-default"
                                data-dismiss="modal">
                            Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div> 
            
        </div>
        <div v-else>
            Não foram encontrados utilizadores, certifique-se que está autenticado como administrador e tente outra vez
            <div v-show="getUsersError">
                <span class="help-block">
                    <strong>{{getUsersErrorMessage}}</strong>
                </span>
            </div> 
        </div>
                  
    </div>
</template>

<script>
    import UserGames from './userGames.vue';
    import UserVictorys from './userVictorys.vue';

    export default {
        data: function(){
            return { 
                selectedUser:[],
                users: [],
                user: null,
                getUsersError: false,
                getUsersErrorMessage: '',
                columns: [{
                          label: 'Nickname',
                          field: 'nickname',
                          filterable: true,
                        },
                        {
                          label: 'Email',
                          field: 'email',
                          filterable: true,
                        },
                        {
                          label: 'Name',
                          field: 'name',
                          filterable: true,
                        },
                        {
                          label: 'Actions',
                          field: 'Actions',
                          filterable: true,
                        },]
                    }
                },
        methods: {
            getUsers: function(){
                axios({
                    method: 'get',
                    url: 'api/users',
                    headers: {
                        'Accept' : 'application/json',
                        'Authorization': 'Bearer ' + this.$root.$data['accessToken']
                    }
                }).then(response=>{
                    console.log(response);
                    this.users = response.data.data; 

                    this.getUsersError = false;
                    this.getUsersErrorMessage = '';
                })
                .catch(error=>{
                    console.log(error);
                    console.log(error.response);

                    this.getUsersError = true;
                    this.getUsersErrorMessage = error.response.data.message;
                });
            },
            getUserStatistics: function (user){
                console.log(user.id);
                axios({method: 'get',
                        url: '/api/statistics/user/'+ user.id,
                        headers: {
                            'Accept' : 'application/json',
                            //'Authorization': 'Bearer ' + this.$root.$data['accessToken']
                        }
                    }).then(response=>{
                        this.selectedUser = response.data;
                    });

                this.user = user;

                this.blockError = false;
                this.blockErrorMessage = '';

                this.reactivatedError = false;
                this.reactivatedErrorMessage = '';                
            },
        },
        components: {
            'UserGames': UserGames,
            'UserVictorys': UserVictorys,
        },
        mounted() {
            this.getUsers();
        }   
    }
</script>