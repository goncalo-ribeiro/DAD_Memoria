<template>
    <div class="container">
        <div class="jumbotron">
            <h1>Utilizadores</h1>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Nickname</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users"  :key="user.id">
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.nickname }}</td>
                    <td>
                        <div v-if="user.admin != 1">
                            <a class="btn btn-xs btn-danger" v-on:click.prevent="">Bloquear</a>
                            <a class="btn btn-xs btn-success" v-on:click.prevent="">Reativar</a>
                            <a class="btn btn-xs btn-primary" v-on:click.prevent="">Edit</a>                            
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>              
    </div>
</template>

<script type="text/javascript">
    // Component code (not registered)
    module.exports={
        data: function(){
            return { 
                users: null
            }
        },
        methods: {
            getUsers: function(){
                axios({
                    method: 'get',
                    url: 'api/users',
                    headers: {
                        'Accept' : 'application/json',
                        'Authorization': 'Bearer ' + this.$root.$data['accessToken']
                    }
                }).then(response=>{
                    console.log(response);
                    this.users = response.data.data; 
                })
                .catch(error=>{
                    console.log(error);
                    console.log(error.response);
                });
            },
        },
        mounted() {
            this.getUsers();
        }   
    }
</script>