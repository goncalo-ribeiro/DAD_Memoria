<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Login</div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label for="login" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input v-model.trim="email" id="login" type="string" class="form-control" name="login" value="" required autofocus>

                            </div>
                        </div>

                        <br><br>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input v-model.trim="password" id="password" type="password" class="form-control" name="password" required>

                                <div v-show="loginError">
                                    <span class="help-block">
                                        <strong>O email ou a password estão mal, tente outra vez</strong>
                                    </span>
                                </div>                                

                            </div>
                        </div>

                        <br><br>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary" @click="login">
                                    Login
                                </button>

                                <a class="btn btn-link" href="">
                                    Forgot Your Password?
                                </a>
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
                accessToken: '',
                loginError: false
            }
        },
        methods: {
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
                            email: this.email,
                            password: this.password
                        }
                    }).then(response=>{
                        this.accessToken = response.data.accessToken;
                        console.log(response);
                        this.loginError = false;   
                        alert("efetuou o login com sucesso!") 
                        
                    })
                    .catch(error=>{
                        console.log(error);
                        this.loginError = true;
                    });
                }
            }
        },
        mounted() {
            console.log('login example mounted.');
        }
    }
</script>
