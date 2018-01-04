<template>
    <div>
        <div class="form-group">
            <label for="oldPassword" class="col-md-4 control-label">Password Antiga</label>

            <div class="col-md-6">
                <input v-model.trim="oldPassword" id="oldPassword" type="password" class="form-control" name="oldPassword" value="" required autofocus>
            </div>
        </div>
        <br><br>

        <div class="form-group">
            <label for="newPassword" class="col-md-4 control-label">New Password</label>

            <div class="col-md-6">
                <input v-model.trim="newPassword" id="newPassword" type="password" class="form-control" name="newPassword" required>

                <div v-show="passwordError">
                    <span class="help-block">
                        <strong>{{passwordErrorMessage}}</strong>
                    </span>
                </div>       
            </div>
        </div>  

        <br><br>

        <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary" @click="updatePassword">
                    Atualizar Password
                </button>
            </div>
        </div>  
        
        <br><br>
        
        <hr />

        <br>

        <div class="form-group">
            <label for="email" class="col-md-4 control-label">Novo Email</label>

            <div class="col-md-6">
                <input v-model.trim="email" id="email" type="text" class="form-control" name="email" value="" autofocus>
                
                <div v-show="emailError">
                    <span class="help-block">
                        <strong>{{emailErrorMessage}}</strong>
                    </span>
                </div>                 
            </div>
        </div>

        <br><br>
        
        <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary" @click="updateEmail">
                    Atualizar Email
                </button>
            </div>
        </div> 

        <br><br>
        
        <hr/>

        <br>

        <div class="form-group">
            <label for="reset" class="col-md-4 control-label">Esqueceu-se da password?</label>
            <div class="col-md-6">
                <button id="reset" type="submit" class="btn btn-warning" @click="resetEmail">
                    Reset da password
                </button>
                <div v-show="passwordResetError">
                    <span class="help-block">
                        <strong>{{passwordResetErrorMessage}}</strong>
                    </span>
                </div> 
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        data: function(){
            return {
                oldPassword: '',
                newPassword: '',
                passwordError: false,
                passwordErrorMessage: '',
                
                email: '',
                emailError: false,
                emailErrorMessage: '',

                passwordResetError: false,
                passwordResetErrorMessage : '',
            }
        },
        methods: {
            updatePassword: function(){
                if (this.oldPassword != "" && this.newPassword != "") {
                    console.log(this.oldPassword + "\t" + this.newPassword);
                    console.log(this.$root.$data['accessToken']);

                    axios({
                        method: 'post',
                        url: '/api/admin/password',
                        headers: {
                            'Accept' : 'application/json',
                            'Content-Type' : 'application/json',
                            'Authorization': 'Bearer ' + this.$root.$data['accessToken']
                        },
                        data: {
                            oldPassword: this.oldPassword,
                            newPassword: this.newPassword
                        }
                    }).then(response=>{
                        console.log(response);

                        this.passwordErrorMessage = '';
                        this.passwordError = false;

                        alert(response.data.message);
                        //this.$emit('logged', this.accessToken);
                        
                    })
                    .catch(error=>{
                        console.log(error);
                        console.log(error.response);
   
                        this.passwordErrorMessage = error.response.data.message;
                        this.passwordError = true;
                    });
                }
            },
            updateEmail: function(){
                if (this.email != "") {
                    console.log(this.email);
                    console.log(this.$root.$data['accessToken']);

                    if (this.checkEmail(this.email)) {
                        axios({
                            method: 'post',
                            url: '/api/admin/email',
                            headers: {
                                'Accept' : 'application/json',
                                'Content-Type' : 'application/json',
                                'Authorization': 'Bearer ' + this.$root.$data['accessToken']
                            },
                            data: {
                                email: this.email,
                            }
                        }).then(response=>{
                            this.emailErrorMessage = '';
                            this.emailError = false;

                            console.log(response);

                            alert(response.data.message);
                            //this.$emit('logged', this.accessToken);
                            
                        })
                        .catch(error=>{
                            console.log(error);
                            console.log(error.response);
       
                            this.emailErrorMessage = error.response.data.message;
                            this.emailError = true;
                        });
                    }
                    else{
                        console.log('checkEmail = false');
                        this.emailErrorMessage = 'Erro, formato de email inválido'
                        this.emailError = true;
                    }
                }                
            },
            checkEmail: function(email) {
                return true
                var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                if (!reg.test(email)) return false;
                return true;
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
                            url: '/api/admin/password/reset',
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


            }
        },
        mounted() {
            console.log('Component config mounted.');
        },
    }
</script>