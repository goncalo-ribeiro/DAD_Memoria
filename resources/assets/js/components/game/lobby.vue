<template>
    <div class="row">
        <div class="col-md-7 col-md-offset-1">
            <newGameForm :user="user" :token="token" v-if="form" @create-click="createGame"></newGameForm>
            <div class="panel panel-default">
                <div class="panel-heading">Game Lobby</div>
                <div class="panel-body">
                    <div v-bind:class="{'col-xs-10': user!=null, 'col-xs-12': user==null}">
                        <table class="table table-striped" style="text-align:center;">
                            <thead>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Players</th>
                                <th>Created By</th>
                                <th>Created At</th>
                            </thead>
                            <tbody>
                                <tr v-for="game in games">
                                    <td>{{ game.gameID }}</td>
                                    <td>{{ game.name }}</td>
                                    <td>{{ game.gameSize }}</td>
                                    <td>{{ game.player }}</td>
                                    <td>{{ game.created }}</td>
                                    <td v-if="user != null"><button class="btn btn-xs btn-success" v-on:click="joinGame(game.gameID)">Join</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-if="user != null" class="col-xs-2">
                        <button  class="btn btn-success" v-on:click="showForm">Novo Jogo</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-md-offset-1">
            <chat :chat="chat" @comment-sent="commentSent"></chat>
        </div>
    </div>
</template>

<script>
import newGameForm from './newGameForm.vue';
import chat from './chat.vue';

export default {
    props: ['games', 'user', 'chat', 'token'],
    data: function(){
        return {
            form: false             
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
        joinGame(game){
            this.$emit('join-game', {gameId: game});
        },
        commentSent(message){
            this.$emit('comment-sent', message);
        }
    },
    components: {
        'newGameForm': newGameForm,
        'chat': chat,
    },
    mounted() {
        console.log('Component container mounted.')
    }
}
</script>
