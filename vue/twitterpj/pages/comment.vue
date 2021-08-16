<template>
    <div class="comment">
        <p class="home-title">コメント</p>
        <table>
            <tr>
                <th>
                    {{userName}}
                </th>
                <th>
                    <Like :post_id="shareId" :user_id="userId"></Like>
                </th>
                <th>
                    <img @click="deleteShare(shareId)" src="../img/cross.png">
                </th>
                    
                
            </tr>
            <tr>
                <td>{{shareData}}</td>
            </tr>    
        </table> 
        <p class="home-title comment-title">コメント</p>
        <table v-for="item in commentContent" :key="item.id">
            <tr>
                <th>
                    <p>{{userName}}</p>
                </th>
            </tr>
            <tr>
                <td>{{item.comment}}</td>
            </tr>
        </table>
        <input class="comment_area" type="text" v-model="comment">
        <button class="comment_btn" @click="upComment">コメント</button>
    </div>
</template>

<script>

export default {
    data() {
        return{
            comment:null,
            userName:null,
            userId:null,
            userEmail:null,
            comment:null,
            shareId:null,
            shareData:null,
            shareContent:null,
            commentContent:[]
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
        
        },


        async upComment(){
            if(!this.comment) {
                alert('コメントの内容を入力してください');
                return
            }
            const sendData = {
                user_id:this.userId,
                share_id:this.shareId,
                comment:this.comment
            }
            await this.$axios.post('http://127.0.0.1:8000/api/comment',sendData);
            this.getComment();
            this.comment=null;
        
        },
        async getComment(){
            const commentData = await this.$axios.get("http://127.0.0.1:8000/api/comment/",{params:{shareId:this.shareId}});
            this.commentContent = commentData.data.data;
        },
        async deleteShare(id){
            await this.$axios.delete('http://127.0.0.1:8000/api/share/'+id);
            this.getShare();
        },
        
        
    },
    created(){
            

            this.$nuxt.$on('requireHelp',()=> {
                this.signOut();
            });

            this.shareId = this.$route.query.shareId;
            this.userId = this.$route.query.userId;
            this.userName = this.$route.query.userName;
            this.shareData =this.$route.query.shareContent;
        
            this.getComment();

            this.$nuxt.$on('up',(value)=> {
            this.shareContent=value;
            this.upContent();
            
        });
    }
    
}
</script>

<style>
.comment {
    width:100%;
}

.comment-title {
    text-align: center;
}
.comment_area {
    width:95%;
    height:25px;
    margin:10px 10px;
    border:1px solid #999;
    border-radius:20px;
    
    
}

.comment_btn{
    display:block;
    margin-left:auto;
}
</style>