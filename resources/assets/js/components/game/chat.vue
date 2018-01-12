<template>
   <div>
        <div class="panel panel-default">    
            <div class="panel-heading"><h1>Global Chat:</h1></div>
            <div class="panel-body">
                <div class="scroll-view">
                    <ul style="list-style-type: none; padding: 0;">
                        <li v-for="n in chat">{{ n }}</li>
                    </ul>
                </div>
                <div class="form-group" v-if="loggedUser">
                   <label for="field1">Comment:</label>
                   <div class="input-group">
                      <input id="comment" type="text"  v-model.trim="comment" class="form-control" placeholder="My comment is..." required>
                      <span class="input-group-btn">
                        <button class="btn btn-success" type="submit" @click="sendComment" v-model="comment">Go!</button>
                      </span>
                   </div>
                </div>
            </div>
        </div>
   </div>
</template>

<script>
    export default {
        props: ['chat'],
        data:function(){
           return {
                comment:"",
           }
        },
        methods: {
            sendComment() {
            	if(this.comment=="") return;
                this.$emit('comment-sent', this.$root.$data['loggedUser'].nickname+": "+this.comment);
                this.comment="";
            }          
        },
        computed: {
            //Check if User is Logged and if is he can leave a comment
            loggedUser: function () {
                if(this.$root.$data['loggedIn']==true && this.$root.$data['loggedUser']!=null) return this.$root.$data['loggedIn'];
                else return this.$root.$data['loggedIn']; 
            }
        },
        watch: {
        	chat: function() {
        		var container = document.querySelector(".scroll-view");
            	var scrollHeight = container.scrollHeight+100;
            	container.scrollTop=scrollHeight;
        	}
        },
        mounted() {
            console.log('Component chat mounted.')
        }
    }
</script>
<style scoped>  
.scroll-view{
    height:200px; 
    max-height:200px; 
    overflow-y: scroll;
    overflow-x: hidden;
    background: lightgrey;
    padding-bottom: 20px;
}
</style>