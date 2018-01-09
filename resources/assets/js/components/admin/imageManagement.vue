<template>
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Gestão das imagens de jogo
                        <div class="nav navbar-nav navbar-right">
                            
                            <a v-on:click="getImages()" style="cursor: pointer; vertical-align:middle; padding-right: 15px;">
                                Atualizar Imagens
                            </a>
                        </div>
                    </div>

                    <div class="panel-body">

                        <h3>Imagens das faces das peças</h3>
                        <div>
                            <br>
                            <p>Adicionar Face</p>
                            <input style="display: inline-block" type="file" @change="processFile($event)">
                            <button type="button" @click="sendFile(0)" class="btn btn-primary btn-sm">Enviar</button>
                            <div v-show="postError[0] == true">
                                <span class="help-block">
                                    <strong>{{postErrorMessage[0]}}</strong>
                                </span>
                            </div>
                            <div v-show="postErrorInfo[0] == true">
                                <span class="help-block">
                                    <strong>{{postErrorInfoMessage[0]}}</strong>
                                </span>
                            </div>  
                            <br v-show="postError[0] == false">
                            <br>
                        </div>
                        <div class="row">
                            <div v-for="(image, key) of getTiles()" class="col-sm-3" style="padding: 20px;">                                    
                                <img v-bind:src="imageURL(image)" style="display: block; margin: 0 auto; width:30%">
                                <div style="padding: 5px;">
                                    <p style="text-align:center">Imagem {{image.id}}</p>   
                                    <span style="display: flex; align-items: center; justify-content: center;">
                                        
                                        <button @click="ativarImagem(image)" style="margin-left: 2px; margin-right: : 2px;" v-if="!image.active" type="button" class="btn btn-primary btn-xs">Ativar</button>
                                        <button @click="desativarImagem(image)" style="margin-left: 2px; margin-right: : 2px;" v-if="image.active" type="button" class="btn btn-warning btn-xs">Desativar</button>
                                        <button @click="removerImagem(image)" style="margin-left: 2px; margin-right: : 2px;" type="button" class="btn btn-danger btn-xs">Remover</button>
                                    </span>                                     
                                </div>
                            </div>
                        </div>

                        <hr>

                        <h3>Imagens das faces escondidas</h3>

                        <div>
                            <br>
                            <p>Adicionar Face escondida</p>
                            <input style="display: inline-block" type="file" @change="processFile($event)">
                            <button type="button" @click="sendFile(1)" class="btn btn-primary btn-sm">Enviar</button>
                            <div v-show="postError[1]">
                                <span class="help-block">
                                    <strong>{{postErrorMessage[1]}}</strong>
                                </span>
                            </div>
                            <div v-show="postErrorInfo[1]">
                                <span class="help-block">
                                    <strong>{{postErrorInfoMessage[1]}}</strong>
                                </span>
                            </div>
                            <br v-show="postError[0] == false">
                            <br>
                        </div>
                        <div class="row">
                            <div v-for="(image, key) of getHidden()" class="col-sm-3" style="padding: 20px;">                                    
                                <img v-bind:src="imageURL(image)" style="display: block; margin: 0 auto; width:30%">
                                <div style="padding: 5px;">
                                    <p style="text-align:center">Imagem {{image.id}}</p>   
                                    <span style="display: flex; align-items: center; justify-content: center;">
                                        
                                        <button @click="ativarImagem(image)" style="margin-left: 2px; margin-right: : 2px;" v-if="!image.active" type="button" class="btn btn-primary btn-xs">Ativar</button>
                                        <button @click="desativarImagem(image)" style="margin-left: 2px; margin-right: : 2px;" v-if="image.active" type="button" class="btn btn-warning btn-xs">Desativar</button>
                                        <button @click="removerImagem(image)" style="margin-left: 2px; margin-right: : 2px;" type="button" class="btn btn-danger btn-xs">Remover</button>
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
                images: [],
                
                getImagesError: false,
                getImagesErrorMessage: '',

                postError: [false, false],
                postErrorMessage: ['', ''],
                postErrorInfo: [false, false],
                postErrorInfoMessage: ['', ''],

                file: false,
            }
        },
        methods: {
            ativarImagem:function(image) {
                axios({
                    method: 'put',
                    url: 'api/images/activate/' + image.id,
                    headers: {
                        'Accept' : 'application/json',
                        'Content-Type' : 'application/json',
                        'Authorization': 'Bearer ' + this.$root.$data['accessToken']
                    }
                })
                .then( ( response ) => {
                    console.log(response);
                    
                    this.getImages();
                    alert(response.data.message);
                } )
                .catch( ( error ) => {
                    console.log(error.response);

                    alert(error.response.data.message);
                } );
            },
            desativarImagem:function(image) {
                axios({
                    method: 'put',
                    url: 'api/images/desactivate/' + image.id,
                    headers: {
                        'Accept' : 'application/json',
                        'Content-Type' : 'application/json',
                        'Authorization': 'Bearer ' + this.$root.$data['accessToken']
                    }
                })
                .then( ( response ) => {
                    console.log(response);
                    
                    this.getImages();
                    alert(response.data.message);
                } )
                .catch( ( error ) => {
                    console.log(error.response);

                    alert(error.response.data.message);
                } );
            },
            removerImagem:function(image) {
                axios.delete( 'api/images/' + image.id)
                axios({
                    method: 'delete',
                    url: 'api/images/' + image.id,
                    headers: {
                        'Accept' : 'application/json',
                        'Content-Type' : 'application/json',
                        'Authorization': 'Bearer ' + this.$root.$data['accessToken']
                    }
                })                
                .then( ( response ) => {
                    console.log(response);
                    
                    this.getImages();
                    alert("Imagem removida com sucesso!");
                } )
                .catch( ( error ) => {
                    console.log(error.response);

                    alert(error.response.data.message);
                } );
            },               
            //$hidden specifies wether the image uploaded is a face or a hidden tile
            sendFile: function($hidden){
                const formData = new FormData();
                formData.append( 'image', this.file );
                formData.append( 'hidden', $hidden );
                console.log(formData);
                //axios.post( 'api/images', formData )
                axios({
                    method: 'post',
                    url: 'api/images',
                    headers: {
                        'Authorization': 'Bearer ' + this.$root.$data['accessToken']
                    },
                    data: formData,
                })
                .then( ( response ) => {
                    console.log("sucesso!")
                    console.log(response);
                    this.clearErrors();
                    this.getImages();
                    alert("Imagem enviada com sucesso");
                } )
                .catch( ( error ) => {
                    console.log("erro!")
                    console.log(error.response);

                    //however $hidden doubles down as the index for the array of errors
                    Vue.set(this.postError, $hidden, true);
                    Vue.set(this.postErrorMessage, $hidden, error.response.data.message);

                    if (error.response.data.errors != null) {
                        Vue.set(this.postErrorInfo, $hidden, true);
                        Vue.set(this.postErrorInfoMessage, $hidden, error.response.data.errors.image[0]);
                    }
                } );
            },
            clearErrors: function(){
                this.postError = [false, false];
                this.postErrorMessage = ['', ''];
                this.postErrorInfo = [false, false];
                this.postErrorInfoMessage = ['', ''];
            },
            processFile: function(event) {
                console.log(event);
                console.log(event.target.files[0]);
                this.file = event.target.files[0]
            },
            getImages: function(){
                axios({
                    method: 'get',
                    url: 'api/images',
                    headers: {
                        'Accept' : 'application/json',
                        'Authorization': 'Bearer ' + this.$root.$data['accessToken']
                    }
                }).then(response=>{
                    console.log(response);
                    this.images = response.data; 

                    this.getImagesError = false;
                    this.getImagesErrorMessage = '';
                })
                .catch(error=>{
                    console.log(error);
                    console.log(error.response);

                    this.getImagesError = true;
                    this.getImagesErrorMessage = error.response.data.message;
                });
            },
            imageURL: function (image) {
                return 'img/' + image.path;
            },
            getTiles: function(){
                return this.images.filter(function(image) {
                    return image.face == 'tile';
                });
            },
            getHidden: function(){
                return this.images.filter(function(image) {
                    return image.face == 'hidden';
                });
            }
        },
        mounted() {
            this.getImages();
            console.log('Component imageManagement mounted.')
        }
    }
</script>
