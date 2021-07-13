<template>
<div>
    <h1>ホームです！</h1>
    <p>{{userName}}</p>
    <p>{{userId}}</p>

</div>    
</template>

<script>
import firebase from '~/plugins/firebase'
export default {
    data(){
        return {
            message:'ログイン',
            stas:'sta',
            userName:null,
            userEmail:null,
            userId:null
            
        }
    },
    methods: {
        async getUser(){
            
                    const userData = await this.$axios.get("http://127.0.0.1:8000/api/user/",{params:{email:this.userEmail}});
                    userData.data.data.forEach(
                        item=>{
                            this.userName= item.user;
                            this.userId = item.id;
                        
                    }
                    )
                    
                
        }
    },
    created(){
        firebase.auth().onAuthStateChanged((user) => {
            if(user) {
                this.userEmail = user.email;
                this.getUser();
            }
        })
    }
}

</script>