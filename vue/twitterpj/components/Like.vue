<template>
    <div class="heart">
        <img v-if="status" src="../img/redheat.png" @click="unlike(post_id)">
        <img v-else src="../img/heart.png" @click="like">
        {{count}}
    </div>
</template>

<script>
export default {
    props:{
        post_id:{
            type:Number,
        },
        user_id:{
            type:Number,
        }
    },
    data(){
        return {
            status : false,
            count:0,
            
        }
    },
    methods:{
        async getLike(){
            const likeData = await this.$axios.get('http://127.0.0.1:8000/api/like',{params:{user_id:this.user_id,share_id:this.post_id}});
            if(likeData.data.user) {
                this.status = true;
            }
            this.count = likeData.data.data;
        },

        async like(){
            const sendData = {
                share_id:this.post_id,
                user_id:this.user_id
        };

        
        await this.$axios.post('http://127.0.0.1:8000/api/like',sendData);

        this.getLike();
        },

        async unlike(id){
        
            await this.$axios.delete('http://127.0.0.1:8000/api/like/'+id,{params:{user_id:this.user_id}});
            this.status = false;
            this.getLike();
        }

    },
    created(){
        this.getLike();
        console.log(this.user_id);
    }
}
</script>

<style>
    .heart {
        display:flex;
    }
</style>