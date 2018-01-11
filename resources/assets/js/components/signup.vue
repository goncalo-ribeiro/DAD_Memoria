<template>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div v-if="this.$root.$data['loggedIn'] == false" class="panel panel-default">
                    <div class="panel-heading">Registo de novos utilizadores</div>

                    <div class="panel-body">

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Nome</label>

                            <div class="col-md-6">
                                <input v-model.trim="name" id="name" type="string" class="form-control" name="name" value="" required autofocus>
                                <div v-if="registerError && errors.name != null">
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

                                <div v-if="registerError && errors.nickname != null">
                                    <span class="help-block">
                                        <strong>{{errors.nickname[0]}}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <br><br>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input v-model.trim="password" id="password" type="password" class="form-control" name="password" required>

                                <div v-if="registerError && errors.password != null">
                                    <span class="help-block">
                                        <strong>{{errors.password[0]}}</strong>
                                    </span>
                                </div>  

                            </div>
                        </div>

                        <br><br>

                        <div class="form-group">
                            <label for="password_confirmation" class="col-md-4 control-label">Confirmação da Password</label>

                            <div class="col-md-6">
                                <input v-model.trim="password_confirmation" id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>

                                <div v-if="registerError && errors.password_confirmation != null">
                                    <span class="help-block">
                                        <strong>{{errors.password_confirmation[0]}}</strong>
                                    </span>
                                </div>                             

                            </div>
                        </div>

                        <br><br>

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">Email</label>

                            <div class="col-md-6">
                                <input v-model.trim="email" id="email" type="email" class="form-control" name="email" required>

                                <div v-if="registerError && errors.email != null">
                                    <span class="help-block">
                                        <strong>{{errors.email[0]}}</strong>
                                    </span>
                                </div>                             

                            </div>
                        </div>

                        <br><br>


                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-success" @click="register()">
                                    Registar
                                </button>
                                <div v-show="registerError">
                                    <span class="help-block">
                                        <strong>Os dados enviados são inválidos, tente outra vez</strong>
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
                password: '',
                password_confirmation: '',
                email: '',

                registerError: false,
                errors: [],
            }
        },
        methods: {
            register: function(){
                console.log('register');
                if (this.name != '' && this.nickname != '' && this.password != '' && this.password_confirmation != '' && this.email != '') {
                    console.log('in!');
                    axios({
                        method: 'post',
                        url: '/api/users',
                        headers: {
                            'Accept' : 'application/json',
                            'Content-Type' : 'application/json'
                        },
                        data: {
                            name: this.name,
                            nickname: this.nickname,
                            password: this.password,
                            password_confirmation: this.password_confirmation,
                            email: this.email,
                        }
                    }).then(response=>{
                        console.log(response);
                        this.registerError = false;
                        this.errors = [];
                        this.password = '';
                        this.password_confirmation = '';

                        alert('Foi enviado um email de verificação de conta para ' + this.email);
                    })
                    .catch(error=>{
                        console.log(error);
                        this.registerError = true;
                        this.errors = error.response.data.errors;
                    });
                }
            },
        },
        mounted() {
            console.log('register example mounted.');
        }
    }
</script>
