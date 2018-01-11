<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Erro inesperado</div>

                    <div class="panel-body">
                        Surgiu um error inesperado, por favor tente outra vez mais tarde.
                        <br>
                        Verifique se tem autorização para aceder a esta página
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component error mounted.')
        },
        methods: {
        }
    }
</script>
