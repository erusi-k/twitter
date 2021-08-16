<template>
<div class="home">
<p class="home-title" >ホーム</p>

    <table v-for="item in contentLists" :key="item.id">
    <tr>
        <th>
            {{userName}}
        </th>
        <th>
            <Like :post_id="item.id" :user_id="userId"></Like>
        </th>
        <th>
            <img @click="deleteShare(item.id)" src="../img/cross.png">
        </th>
        <th>
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
            shareId:null,
            shareContent:null,
            contentLists:[],
            likeDatas:[]
            
            
        }
    },
    methods: {
        //シェア投稿
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
        
        //シェア取得
        async getShare(){
            var user = Number(this.userId)
        
            const shareData = await this.$axios.get('http://127.0.0.1:8000/api/share',{params:{user_id:this.userId}});
            this.contentLists = shareData.data.data;
        },

        //シェア削除
        async deleteShare(id){
            await this.$axios.delete('http://127.0.0.1:8000/api/share/'+id);
            this.getShare();
        },

        //ユーザー取得
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
        //コメント一覧に移動
        movePage(item,content){
            this.$router.push({path:'comment',query:{shareId:item,userId:this.userId,userName:this.userName,shareContent:content}});
        },

    },
    created(){
        firebase.auth().onAuthStateChanged((user) => {
            if(user) {
                
                this.userEmail = user.email;
                this.getUser(this.getShare);
            }
            else{
                this.$router.push('/');
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
        
        display:flex;
        justify-content: flex-start;
    }

    th {
        
        margin-left: 20px;
    }
    
</style>
