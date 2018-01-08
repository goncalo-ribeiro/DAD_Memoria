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
                        <div class="row">
                            <div v-for="(image, key) of getTiles()" class="col-sm-3" style="padding: 20px;">                                    
                                <img v-bind:src="imageURL(image)" style="display: block; margin: 0 auto; width:30%">
                                <div style="padding: 5px;">
                                    <p style="text-align:center">Imagem {{image.id}}</p>   
                                    <span style="  display: flex; align-items: center; justify-content: center;">
                                        
                                        <button style="margin-left: 2px; margin-right: : 2px;" v-if="image.active" type="button" class="btn btn-primary btn-xs">Ativar</button>
                                        <button style="margin-left: 2px; margin-right: : 2px;" v-if="!image.active" type="button" class="btn btn-warning btn-xs">Desativar</button>
                                        <button style="margin-left: 2px; margin-right: : 2px;" type="button" class="btn btn-danger btn-xs">Remover</button>
                                    </span>                                     
                                </div>
                            </div>
                        </div>

                        <hr>

                        <h2>Imagens das faces escondidas</h2>

                        <div class="board" style="text-align:center">
                            <span style="padding-top: 20px; padding-bottom: 20px; display: inline-block;" v-for="(image, key) of getHidden()">
                                <img v-bind:src="imageURL(image)" style="width:40%">
                                <div style="padding: 20px; display: inline-block;">
                                    <p>Imagem {{image.id}}</p>
                                    <button v-if="image.active" type="button" class="btn btn-primary btn-xs">Ativar</button>
                                    <button v-if="!image.active" type="button" class="btn btn-warning btn-xs">Desativar</button>
                                    <button type="button" class="btn btn-danger btn-xs">Remover</button>
                                </div>
                            </span>
                        </div>
<!--
                        <div class="board" style="text-align:center">   
                            <div class="col-md-3" style="padding: 15px"> 
                                <span v-for="(image, key) of getHidden()">
                                
                                    <img v-bind:src="imageURL(image)" style="width:60%">
                                    <div style="padding: 30px">
                                        <p>Imagem {{image.id}}</p>
                                        <button v-if="image.active" type="button" class="btn btn-primary btn-xs">Ativar</button>
                                        <button v-if="!image.active" type="button" class="btn btn-warning btn-xs">Desativar</button>
                                        <button type="button" class="btn btn-danger btn-xs">Remover</button>
                                    </div>
                                </span> 
                            </div>
                        </div>
                        -->

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
            }
        },
        methods: {
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
