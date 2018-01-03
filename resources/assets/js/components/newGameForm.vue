<template>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">New Game</div>
            <div class="panel-body">
                <label for="players">Players: </label>
                <select v-on:change="changeSize" v-model="size" name="players">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>
                <label for="settings">Default Settings: </label>
                <input v-model="defaultSettings" type="checkbox" name="settings" v-on:click="changeDefault" checked>
                <span v-if="!defaultSettings">
                    <label for="linhas">Linhas: </label>
                    <select v-on:change="changeTotal" v-model="linhas" name="linhas">
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                    </select>
                    <label for="colunas">Colunas: </label>
                    <select v-on:change="changeTotal" v-model="colunas" name="colunas">
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </span>
                <button class="btn btn-success" v-on:click="submeter" style="float:right">New Game</button>
                <div class="alert alert-danger" v-if="showError">
                    <strong>{{ error }}</strong>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import newGameForm from './newGameForm.vue';

export default {
    data: function(){
        return {
            showError: false,
            error: '',
            size: 1,
            defaultSettings: true,
            linhas: 4,
            colunas: 4,
        }
    },
    methods:{
        submeter(){
            if(this.showError==false){
                this.$emit('create-click', {size: this.size, linhas: this.linhas, colunas: this.colunas});
            }
        },
        changeSize(){
            if(this.size > 2){
                this.colunas=6;
            }else{
                this.colunas=4;
            }
            if(this.size>3){
                this.linhas=6;
            }else{
                this.linhas=4;
            }
        },
        changeTotal(){
            if(this.linhas*this.colunas%2!=0){
                this.error= '' + this.linhas + ' Linhas e ' + this.colunas + ' Colunas dá ' + this.linhas*this.colunas + ' peças, que não é numero par, selecione uma configuração diferente';
                this.showError=true;
            }else{
                this.showError=false;
            }
        },
        changeDefault(){
            this.defaultSettings=!this.defaultSettings;
        },
    },
    mounted() {
        console.log('Component container mounted.')
    }
}
</script>
