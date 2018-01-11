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
                            <div v-if="user.admin != 1">
                                <a v-if="user.blocked == 0" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalBlock" v-on:click="setUser(user)">Bloquear</a>
                                <a v-if="user.blocked == 1" class="btn btn-xs btn-success" data-toggle="modal" data-target="#modalReactivate" v-on:click="setUser(user)">Reativar</a>
                                <a class="btn btn-xs btn-danger" v-on:click.prevent="remove(user)">Remover</a>                            
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Modal Block -->
            <div class="modal fade" id="modalBlock" tabindex="-1" role="dialog" 
                 aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <button type="button" class="close" 
                               data-dismiss="modal">
                                   <span aria-hidden="true">&times;</span>
                                   <span class="sr-only">Fechar</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">
                                Bloquear utilizador
                            </h4>
                        </div>
                        
                        <!-- Modal Body -->
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="reason_blocked">Razão do bloqueio:</label>
                                <textarea v-model.trim="reason_blocked" class="form-control" rows="5" id="reason_blocked"></textarea>
                                <div v-show="blockError">
                                    <span class="help-block">
                                        <strong>{{blockErrorMessage}}</strong>
                                    </span>
                                </div> 
                            </div>
                            
                        </div>
                        
                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button id="closeModalBlock" type="button" class="btn btn-default"
                                    data-dismiss="modal">
                                Fechar
                            </button>
                            <button type="button" class="btn btn-primary" v-on:click.prevent="blockUser()">
                                Bloquear
                            </button>
                        </div>
                    </div>
                </div>
            </div>    

                        <!-- Modal Block -->
            <div class="modal fade" id="modalReactivate" tabindex="-1" role="dialog" 
                 aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <button type="button" class="close" 
                               data-dismiss="modal">
                                   <span aria-hidden="true">&times;</span>
                                   <span class="sr-only">Fechar</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">
                                Reativar utilizador
                            </h4>
                        </div>
                        
                        <!-- Modal Body -->
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="reason_reactivated">Razão da reativação:</label>
                                <textarea v-model.trim="reason_reactivated" class="form-control" rows="5" id="reason_reactivated"></textarea>
                                <div v-show="reactivatedError">
                                    <span class="help-block">
                                        <strong>{{reactivatedErrorMessage}}</strong>
                                    </span>
                                </div> 
                            </div>
                            
                        </div>
                        
                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button id="closeModalReativate" type="button" class="btn btn-default"
                                    data-dismiss="modal">
                                Fechar
                            </button>
                            <button type="button" class="btn btn-primary" v-on:click.prevent="reactivateUser()">
                                Reativar
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
    export default {
        data: function(){
            return { 
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
                console.log('setUser ' + user)
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
        mounted() {
            this.getUsers();
        }   
    }
</script>