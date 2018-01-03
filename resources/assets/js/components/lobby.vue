<template>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <newGameForm v-if="form" @create-click="createGame"></newGameForm>
            <div v-if="!form" class="panel panel-default">
                <div  class="panel-heading">Game Lobby</div>
                <div class="panel-body">
                    <div class="col-xs-10">
                        <table class="table table-striped" style="text-align:center;">
                            <thead>
                                <th>ID</th>
                                <th>Players</th>
                                <th>Created By</th>
                                <th>Created At</th>
                            </thead>
                            <tbody>
                                <tr v-for="game in games">
                                    <td>{{ game.gameID }}</td>
                                    <td>{{ game.players.length }}/{{ game.gameSize }}</td>
                                    <td>{{ game.players[0].id }}</td>
                                    <td>NO FUCKING CLUE</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-xs-2">
                        <button class="btn btn-success" v-on:click="showForm">Novo Jogo</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import newGameForm from './newGameForm.vue';

export default {
    props: ['games'],
    data: function(){
        return {
            form: false,
        }
    },
    methods:{
        showForm(){
            this.form=!this.form;
        },
        createGame(data){
                this.$emit('create-click', data);
                this.form=false;
        },
    },
    components: {
        'newGameForm': newGameForm,
    },
    mounted() {
        console.log('Component container mounted.')
    }
}
</script>
