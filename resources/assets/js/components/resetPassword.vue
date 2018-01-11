<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Reset Password</div>

                    <div class="panel-body">

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">Endereço de email</label>

                            <div class="col-md-6">
                                <input v-model.trim="email" id="email" type="email" class="form-control" name="email" required autofocus>                               
                            </div>
                        </div>

                        <br><br>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input v-model.trim="password" id="password" type="password" class="form-control" name="password" required>
                            </div>
                        </div>

                        <br><br>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirme a Password</label>
                            <div class="col-md-6">
                                <input v-model.trim="password_confirmation" id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                <span v-show="resetError" class="help-block">
                                    <strong>{{ resetErrorMessage }}</strong>
                                </span>
                            </div>
                        </div>
                        
                        <br><br>
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button @click="reset" class="btn btn-primary">
                                    Reset Password
                                </button>
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
                email: '',
                password: '',
                password_confirmation: '',

                resetError: false,
                resetErrorMessage: '',

                token: '',
            }
        },
        methods: {
            reset: function(){
                this.token = this.$root.$data['resetToken'];
                console.log('resetting password ' + this.token + this.email + this.password + this.password_confirmation);

                axios({
                    method: 'post',
                    url: '/api/password/reset',
                    headers: {
                        'Accept' : 'application/json',
                        'Content-Type' : 'application/json'
                    },
                    data: {
                        email: this.email,
                        token: this.token,
                        password: this.password,
                        password_confirmation: this.password_confirmation,
                    }
                }).then(response=>{

                    this.login();

                    this.resetError = false;
                    this.resetErrorMessage = '';
                    this.email

                    this.password = '';
                    this.password_confirmation = '';

                    alert("efetuou o reset da password com sucesso!");
                    //this.$emit('logged', this.accessToken);
                    
                })
                .catch(error=>{
                    console.log(error);
                    this.resetError = true;
                    this.resetErrorMessage = error.response.data.message;
                });

            },
            login: function(){
                if (this.email != "" && this.password != "") {
                    console.log(this.email + "\t" + this.password)

                    axios({
                        method: 'post',
                        url: '/api/login',
                        headers: {
                            'Accept' : 'application/json',
                            'Content-Type' : 'application/json'
                        },
                        data: {
                            nickname: this.email,
                            password: this.password
                        }
                    }).then(response=>{
                        this.$root.$data['accessToken'] = response.data.access_token;
                        this.$root.$data['loggedIn'] = true;
                        console.log(response);
                        
                        this.setUpLoggedInUser();
                    })
                    .catch(error=>{
                        console.log(error);
                    });
                }
            },
            setUpLoggedInUser: function(){
                axios({
                    method: 'get',
                    url: '/api/user',
                    headers: {
                        'Authorization': 'Bearer ' + this.$root.$data['accessToken'],
                        'Accept' : 'application/json',
                        'Content-Type' : 'application/json'
                    },
                }).then(response=>{
                    this.$root.$data['loggedUser'] = response.data;

                    if (response.data.admin == 1) {
                        console.log('admin');
                        this.$root.$data['admin'] = true;
                    }
                    else{
                        this.$root.$data['admin'] = false;   
                    }

                }).catch(error=>{
                    console.log(error);
                    console.log("erro ao buscar os dados do utilizador!");                           
                });
            },
        },   
        mounted() {
            console.log('Component reset password mounted.')
            this.token = this.$root.$data['resetToken'];
        }
    }
</script>
