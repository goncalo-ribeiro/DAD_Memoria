<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Example Component</div>

                    <div class="panel-body">
                        I'm an example component!
                        <input type="file" @change="processFile($event)">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component example mounted.')
        },
        data: function(){
            return {
                someData: false,
            }
        },
        methods: {
            processFile: function(event) {
                console.log(event);
                console.log(event.target.files[0]);
                this.someData = event.target.files[0]
            }
        }
    }
</script>
