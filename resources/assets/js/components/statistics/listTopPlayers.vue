<template>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><h1>Top Players:</h1></div>

                    <div class="panel-body">
                        <table v-if="" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Vitorias</th>
                                </tr>
                            </thead>
                            <tbody>   
                                <tr v-for="player in players" :key="player.nick">
                                   <td>{{ player.nick }}</td>
                                   <td>{{ player.games }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    "use strict";
        export default{
            props: ['players'],
            data: function () {
                return {
                }
            },

            methods: {
            //Opens edit form
            clickEdit: function(){
               
            },

        },
        mounted(){
                              
        }
    }
</script>
