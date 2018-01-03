<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Administração
                        <ul class="list-inline pull-right">
                            <li class="list-inline-item">Admin</li>
                            <li class="list-inline-item">Utilizadores</li>
                            <li class="list-inline-item">Imagens</li>
                        </ul>
                    </div>

                    <div class="panel-body">
                        I'm an admin component!
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component admin mounted.')
        }
    }
</script>
