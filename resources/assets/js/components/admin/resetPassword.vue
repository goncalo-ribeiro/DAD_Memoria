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

                                
                                <span v-show="emailError" class="help-block">
                                    <strong>{{ emailErrorMessage }}</strong>
                                </span>
                                
                            </div>
                        </div>

                        <br><br>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input v-model.trim="password" id="password" type="password" class="form-control" name="password" required>

                                
                                <span v-show="passwordError" class="help-block">
                                    <strong>{{ passwordErrorMessage }}</strong>
                                </span>
                                
                            </div>
                        </div>

                        <br><br>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirme a Password</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                <span v-show="passwordConfirmError" class="help-block">
                                    <strong>{{ passwordConfirmErrorMessage }}</strong>
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

                emailError: false,
                emailErrorMessage: '',

                passwordError: false,
                passwordErrorMessage: '',
                
                passwordConfirmError: false,
                passwordConfirmErrorMessage : '',

                token: '',
            }
        },
        methods: {
            reset: function(){
                this.token = this.$root.$data['resetToken'];
                console.log('resetting password ' + this.token + this.email + this.password + this.password_confirmation);

                axios({
                    method: 'post',
                    url: '/api/admin/password/reset',
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
                    this.$root.$data['accessToken'] = response.data.access_token;
                    console.log(response);
                    this.loginError = false;
                    this.loggedIn = true;
                    this.$root.$data['loggedIn'] = true; 
                    if (this.nickname == 'admin' || this.nickname == 'admin@mail.dad') {
                        console.log('admin');
                        this.$root.$data['admin'] = true;
                    }
                    else{
                        this.$root.$data['admin'] = false;   
                    }
                    //alert("efetuou o login com sucesso!");
                    //this.$emit('logged', this.accessToken);
                    
                })
                .catch(error=>{
                    console.log(error);
                    this.loginError = true;
                    //alert("credenciais erradas tente outra vez!") 
                });

            },
        },   
        mounted() {
            console.log('Component reset password mounted.')
            this.token = this.$root.$data['resetToken'];
        }
    }
</script>
