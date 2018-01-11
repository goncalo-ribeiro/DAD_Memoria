<template>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Editar dados de utilizador</div>

                    <div class="panel-body">

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Nome</label>

                            <div class="col-md-6">
                                <input v-model.trim="name" id="name" type="string" class="form-control" name="name" value="" required autofocus>
                                <div v-if="editError && errors.name != null">
                                    <span class="help-block">
                                        <strong>{{errors.name[0]}}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <br><br>

                        <div class="form-group">
                            <label for="nickname" class="col-md-4 control-label">Nickname</label>

                            <div class="col-md-6">
                                <input v-model.trim="nickname" id="nickname" type="string" class="form-control" name="nickname" value="" required>

                                <div v-if="editError && errors.nickname != null">
                                    <span class="help-block">
                                        <strong>{{errors.nickname[0]}}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <br><br>

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">Email</label>

                            <div class="col-md-6">
                                <input v-model.trim="email" id="email" type="email" class="form-control" name="email" required>

                                <div v-if="editError && errors.email != null">
                                    <span class="help-block">
                                        <strong>{{errors.email[0]}}</strong>
                                    </span>
                                </div>                             

                            </div>
                        </div>

                        <br><br>


                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-success" @click="edit()">
                                    Atualizar dados
                                </button>
                                <div v-show="editError">
                                    <span class="help-block">
                                        <strong>Os dados enviados são inválidos, tente outra vez</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <br><br>                            

                        <hr>
                        
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-warning" @click="resetEmail()">
                                    Reset da Password
                                </button>
                                <button type="submit" class="btn btn-danger" @click="removeUser()">
                                    Eliminar Conta
                                </button>
                                <div v-show="editError">
                                    <span class="help-block">
                                        <strong>Os dados enviados são inválidos, tente outra vez</strong>
                                    </span>
                                </div>
                                <div v-show="passwordResetError">
                                    <span class="help-block">
                                        <strong>{{passwordResetErrorMessage}}</strong>
                                    </span>
                                </div> 
                            </div>
                        </div>

                            
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function(){
            return {
                name: '',
                nickname: '',
                email: '',

                editError: false,
                errors: [],

                passwordResetErrorMessage: false,
                passwordResetError: ''
            }
        },
        methods: {
            edit: function(){
                console.log('edit');
                if (this.name != '' && this.nickname != '' && this.email != '' && this.$root.$data['loggedUser'] != null) {
                    console.log('in!');
                    axios({
                        method: 'put',
                        url: '/api/users/' + this.$root.$data['loggedUser'].id,
                        headers: {
                            'Accept' : 'application/json',
                            'Content-Type' : 'application/json',
                            'Authorization': 'Bearer ' + this.$root.$data['accessToken']
                        },
                        data: {
                            name: this.name,
                            nickname: this.nickname,
                            email: this.email,
                        }
                    }).then(response=>{
                        console.log(response);
                        this.editError = false;
                        this.errors = [];
                        this.$root.$data['loggedUser'] = response.data.data;
                        alert('O utilizador foi editado com sucesso');
                    })
                    .catch(error=>{
                        console.log(error);
                        this.editError = true;
                        this.errors = error.response.data.errors;
                    });
                }
            },
            resetEmail: function(){
                var user;

                axios({
                    method: 'get',
                    url: '/api/user',
                    headers: {
                        'Accept' : 'application/json',
                        'Authorization': 'Bearer ' + this.$root.$data['accessToken']
                    }
                }).then(response=>{
                    console.log(response);

                    user = response.data;

                    if (confirm('Tem a certeza que deseja fazer um reset à password?\nSerá enviado um link de reset para o email ' + user.email)) {
                        console.log('reset');
                        axios({
                            method: 'post',
                            url: '/api/password/email',
                            headers: {
                                'Accept' : 'application/json',
                                'Content-Type' : 'application/json',
                                'Authorization': 'Bearer ' + this.$root.$data['accessToken']
                            },
                            data: {
                                email: user.email,
                            }
                        }).then(response=>{
                            console.log(response);

                            alert(response.data.message);
                            //this.$emit('logged', this.accessToken);
                            
                        })
                        .catch(error=>{
                            console.log(error);
                            console.log(error.response);
       
                            this.passwordResetErrorMessage = error.response.data.message;
                            this.passwordResetError = true;
                        });
                    } else {
                        console.log('reset canceled!');
                    }                    
                    
                })
                .catch(error=>{
                    console.log(error);
                    console.log(error.response);
                });


            },
            removeUser: function (){
                var user;

                axios({
                    method: 'get',
                    url: '/api/user',
                    headers: {
                        'Accept' : 'application/json',
                        'Authorization': 'Bearer ' + this.$root.$data['accessToken']
                    }
                }).then(response=>{
                    console.log(response);

                    user = response.data;

                    console.log('remove')
                    axios({
                        method: 'delete',
                        url: '/api/users/' + user.id,
                        headers: {
                            'Accept' : 'application/json',
                            'Content-Type' : 'application/json',
                            'Authorization': 'Bearer ' + this.$root.$data['accessToken']
                        },
                    }).then(response=>{   
                        console.log(response); 
                        alert('O utilizador foi removido com sucesso');
                        this.logout();
                        //this.$emit('logged', this.accessToken);
                        
                    })
                    .catch(error=>{
                        console.log(error);
                        console.log(error.response);

                        alert(response.data.message);
                    });
                })
                .catch(error=>{
                    console.log(error);
                    console.log(error.response);
                });                    
            },
            logout: function(){
                this.$root.$data['accessToken'] = '';
                this.$root.$data['loggedIn'] = false; 
                this.$root.$data['admin'] = false;
                this.$root.$data['loggedUser'] = null;
                this.$root.$router.push('/login');
            },

        },
        mounted() {
            
            console.log('edit example mounted.');
        }
    }
</script>
