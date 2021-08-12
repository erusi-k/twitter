<template>
<div class="home">
<p class="home-title" >ホーム</p>

    <table v-for="item in contentLists" :key="item.id">
    <div></div>
    <tr>
        <th>
            
            {{userName}}
            <img src="../img/heart.png" class="like_btn" v-if="(item.likeUser===userId)">
            <img src="../img/profile.png" class="unlike_btn" v-else>
            {{item.like}}

            <img @click="deleteShare(item.id)" src="../img/cross.png">
            <img @click="movePage(item.id,item.share_content)" src="../img/detail.png">
        </th>
    </tr>
    <tr>
        <td>{{item.share_content}}</td>
    </tr>
    
    </table>
    
    
    

</div>    
</template>
<script>

import firebase from '~/plugins/firebase'
export default {

    
    
    data(){
        return {
            userName:null,
            userEmail:null,
            userId:null,
            shareContent:null,
            contentLists:[],
            likeDatas:[]
            
            
        }
    },
    methods: {
        async  upContent(){
            if(!this.shareContent) {
                alert('シェアの内容を入力ください')
                return 
            }
        const sendData = {
                share_content: this.shareContent,
                user_id:this.userId
                };
        await this.$axios.post('http://127.0.0.1:8000/api/share',sendData);
        this.getShare();
        },
        
        async getShare(){
            var user = Number(this.userId)
        
            const shareData = await this.$axios.get('http://127.0.0.1:8000/api/share',{params:{user_id:user}});
            console.log(shareData);
            this.contentLists = shareData.data.data;
            this.likeDatas = shareData.data.likes;
            

            
            
        },
        async deleteShare(id){
            await this.$axios.delete('http://127.0.0.1:8000/api/share/'+id);
            this.getShare();
        },
        async getUser(fn){
            const userData = await this.$axios.get("http://127.0.0.1:8000/api/user/",{params:{email:this.userEmail}});
            userData.data.data.forEach(
                item=>{
                    this.userName= item.user;
                    this.userId = item.id;
            },
            
            );
            this.like = userData,
            await fn();
            
        },
        
        //ログアウト
        signOut(){
            firebase.auth().onAuthStateChanged((user) => {
                firebase.auth().signOut().then(()=>{
                    console.log('ログアウトしました');
                    this.$router.push('login');
                })
                .cathch((error)=>{
                    console.log('ログアウト時にエラーが発生しました(${error})')
                });
            });
        },

        movePage(item,content){
            this.$router.push({path:'comment',query:{shareId:item,userId:this.userId,userName:this.userName,shareContent:content}});
        },

        // async getLike(){
        //     let likeData = [];
        //     for(item in contentLists){
        //         likeData.push(await this.$axios.get('http://127.0.0.1:8000/api/like/',{params:{share_id:item.id}}));
        //     }
        //     this.likeData = likeData;
        //     console.log(likeData);
        // }
    },
    created(){
        firebase.auth().onAuthStateChanged((user) => {
            if(user) {
                
                this.userEmail = user.email;
                this.getUser(this.getShare);
                
            }
        }),
        this.$nuxt.$on('requireHelp',()=> {
            this.signOut();
        });
        this.$nuxt.$on('up',(value)=> {
            this.shareContent=value;
            this.upContent();
            
        });
    },
    
}
    


</script>

<style>
    .home {
        width:100%;
    }

    img {
        
        width: 25px;
        height: 25px;
    }
    
    .home-title {
        border:1px solid #fff;
        border-top:none;
        margin:0px;
    }
    table{
        width:100%;
        border:1px solid #fff;
    }

    tr {
        text-align: left;
    }

    th img {
        margin-left: 20px;
    }
    
    th img:nth-of-type(3) {
        margin-left:50px;
    }

    .unlike_btn img{
        filter: grayscale(100%);
}
    
</style>
