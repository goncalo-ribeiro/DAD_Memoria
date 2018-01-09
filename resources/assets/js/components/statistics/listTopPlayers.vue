<template>
<div>
    <div class="panel panel-default" style="overflow:auto;">
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
