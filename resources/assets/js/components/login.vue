<template>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div v-if="loggedIn == false" class="panel panel-default">
                    <div class="panel-heading">Login</div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label for="login" class="col-md-4 control-label">Nickname</label>

                            <div class="col-md-6">
                                <input @keyup.enter="login" v-model.trim="nickname" id="login" type="string" class="form-control" name="login" value="" required autofocus>

                            </div>
                        </div>

                        <br><br>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input @keyup.enter="login" v-model.trim="password" id="password" type="password" class="form-control" name="password" required>

                                <div v-show="loginError">
                                    <span class="help-block">
                                        <strong>O nickname ou a password estão mal, tente outra vez</strong>
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
                            </div>
                        </div>
                    
                    </div>
                </div>

                <div v-if="loggedIn" class="panel panel-default">
                    <div class="panel-heading">You are logged in</div>
                    <div class="panel-body">
                        

                        <div class="form-group">
                            <label for="login" class="col-md-4 control-label">
                                Do you want to logout?
                            </label>

                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary" @click="logout">
                                    Logout
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
                nickname: 'admin',
                password: '',
                loginError: false,
                loggedIn: false
            }
        },
        methods: {
            login: function(){
                if (this.nickname != "" && this.password != "") {
                    console.log(this.nickname + "\t" + this.password)

                    axios({
                        method: 'post',
                        url: '/api/login',
                        headers: {
                            'Accept' : 'application/json',
                            'Content-Type' : 'application/json'
                        },
                        data: {
                            nickname: this.nickname,
                            password: this.password
                        }
                    }).then(response=>{
                        this.$root.$data['accessToken'] = response.data.access_token;
                        console.log(response);
                        this.loginError = false;
                        this.loggedIn = true;
                        this.$root.$data['loggedIn'] = true;

                        this.setUpLoggedInUser();
                    })
                    .catch(error=>{
                        console.log(error.response);
                        this.loginError = true;
                    });
                }
            },
            logout: function(){
                this.$root.$data['accessToken'] = '';
                this.$root.$data['loggedIn'] = false; 
                this.$root.$data['admin'] = false;
                this.$root.$data['loggedUser'] = null;
                this.loggedIn = false;
                this.password = '';
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
            console.log('login example mounted.');
        }
    }
</script>
