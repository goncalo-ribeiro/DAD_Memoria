<template>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div  class="panel-heading">Replay Lobby</div>
                <div class="panel-body">
                    <table class="table table-striped" style="text-align:center;">
                        <thead>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Players</th>
                            <th>Created By</th>
                            <th>Winner</th>
                            <th>Created At</th>
                        </thead>
                        <tbody>
                            <tr v-for="game in games">
                                <td>{{ game.gameID }}</td>
                                <td>{{ game.name }}</td>
                                <td>{{ game.gameSize }}</td>
                                <td>{{ game.player }}</td>
                                <td>{{ game.winner }}</td>
                                <td>{{ game.created }}</td>
                                <td><button class="btn btn-xs btn-success" v-on:click="view(game.gameID)">View</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['games', 'user'],
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
        view(game){
            this.$emit('view', {gameId: game});
        }
    },
    mounted() {
        console.log('Component container mounted.')
    }
}
</script>
