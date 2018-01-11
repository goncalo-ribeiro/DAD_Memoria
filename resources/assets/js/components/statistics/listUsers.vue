<template>
    <div class="container">
        <div class="jumbotron">
            <h1 style="display: inline-block;">Utilizadores</h1>
            <img align="right" src="img/refresh.png" v-on:click="getUsers(key)" style="max-width: 35px; cursor: pointer; vertical-align:middle;">
        </div>
        
        <div v-if="typeof users !== 'undefined' && users.length > 0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Nickname</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users"  :key="user.id">
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.nickname }}</td>
                        <td>
                            <div >
                                <a v-if="user.blocked == 0" class="btn btn-xs btn-success" data-toggle="modal" data-target="#modalBlock" v-on:click="setUser(user)">Detalhes</a>          
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Modal Block -->
            <div class="modal fade" id="modalBlock" tabindex="-1" role="dialog" 
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
                reason_blocked: '',
                reason_reactivated: '',

                blockError: false,
                blockErrorMessage: '',

                reactivatedError: false,
                reactivatedErrorMessage: '',

                getUsersError: false,
                getUsersErrorMessage: '',
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
            setUser: function (user){
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
            blockUser: function (){
                axios({
                    method: 'put',
                    url: '/api/users/block/' + this.user.id,
                    headers: {
                        'Accept' : 'application/json',
                        'Content-Type' : 'application/json',
                        'Authorization': 'Bearer ' + this.$root.$data['accessToken']
                    },
                    data: {
                        reason_blocked: this.reason_blocked,
                    }
                }).then(response=>{    
                    this.blockError = false;
                    this.blockErrorMessage = '';

                    console.log(response);

                    this.reason_blocked = '';

                    var modalClose = document.getElementById('closeModalBlock');
                    modalClose.click()

                    alert(response.data.message);

                    this.getUsers()
                    //this.$emit('logged', this.accessToken);
                    
                })
                .catch(error=>{
                    console.log(error);
                    console.log(error.response);

                    this.blockError = true;
                    this.blockErrorMessage = error.response.data.message;
                });
            },
            reactivateUser: function (){
                axios({
                    method: 'put',
                    url: '/api/users/reactivate/' + this.user.id,
                    headers: {
                        'Accept' : 'application/json',
                        'Content-Type' : 'application/json',
                        'Authorization': 'Bearer ' + this.$root.$data['accessToken']
                    },
                    data: {
                        reason_reactivated: this.reason_reactivated,
                    }
                }).then(response=>{    
                    this.reactivatedError = false;
                    this.reactivatedErrorMessage = '';

                    console.log(response);

                    this.reason_reactivated = '';

                    var modalClose = document.getElementById('closeModalReativate');
                    modalClose.click()

                    alert(response.data.message);

                    this.getUsers()
                    //this.$emit('logged', this.accessToken);
                    
                })
                .catch(error=>{
                    console.log(error);
                    console.log(error.response);

                    this.reactivatedError = true;
                    this.reactivatedErrorMessage = error.response.data.message;
                });
            },
            remove: function (user){
                console.log('remove')
                this.setUser(user);
                axios({
                    method: 'delete',
                    url: '/api/users/' + this.user.id,
                    headers: {
                        'Accept' : 'application/json',
                        'Content-Type' : 'application/json',
                        'Authorization': 'Bearer ' + this.$root.$data['accessToken']
                    },
                }).then(response=>{   
                    console.log(response); 
                    alert('O utilizador foi removido com sucesso');

                    this.getUsers()
                    //this.$emit('logged', this.accessToken);
                    
                })
                .catch(error=>{
                    console.log(error);
                    console.log(error.response);

                    alert(response.data.message);
                });
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