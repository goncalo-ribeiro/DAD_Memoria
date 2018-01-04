<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Administração
                        <ul class="list-inline pull-right">
                            <li class="list-inline-item">
                                <router-link to="/example">Admin</router-link>
                            </li>
                            <li class="list-inline-item">
                                <router-link to="/example">Utilizadores</router-link>
                            </li>
                            <li class="list-inline-item">
                                <router-link to="/example">Imagens do jogo</router-link>
                            </li>
                        </ul>
                    </div>

                    <div class="panel-body">
                        <config></config>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import config from './admin/adminConfig.vue';

    export default {
        mounted() {
            console.log('Component admin mounted.')
        },
        components: {
            'config': config,
        },
    }
</script>
