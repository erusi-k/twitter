<template>
    <div class="content">
        <div class="layout">
            <img class="layout-title" src="../img/logo.png">
            <div class="menu">
                <NuxtLink to="/home"><img class="img" src="../img/home.png" > ホーム</NuxtLink>
                <p class="menu-logout" @click="clickSignOut"><img class="img" src="../img/logout.png" > ログアウト</p>
            </div>
            <div class="share_up">
                <p>シェア</p>
                <input class="txt" type="text" v-model="shareContent">
                <shareButton class="btn" @click.native="upContent"></shareButton>               
            </div>   
        </div>    
        <Nuxt />
    </div>    
</template>

<script>

import ShareButton from '~/components/ShareButton.vue'
export default {
    components:{
            ShareButton
    },
    data() {
        return {
            shareContent:null
        }
    },
    
    methods: {
        clickSignOut(){
            this.$nuxt.$emit('requireHelp')
        },
        async upContent(){
        await this.$nuxt.$emit('up',this.shareContent);
        this.shareContent=null;
        }

    }

}
</script>

<style>
    body {
        background-color:#000033;
        margin:0px;
    }
    input {
        background-color:#000033;
        color:#fff;
    }

    a {
        text-decoration: none;
        color:#fff;
        
    }

    .content {
        color:#fff;
        
    }

    .layout {
        width:30%;
        margin-right:10px;
    }

    .layout-title{
        width:80px;
        height:30px;
    }

    .img {
        width:25px;
        height:25px;
    }

    .menu {
        display:flex;
        flex-direction: column;
    }
    .menu-logout:hover{
        cursor:pointer;
    }
    
    .content {
        display: flex;
    }
    
    .btn {
        display:block;
        margin-top:10px;
        margin-left: auto;
    }

    .txt {
        width: 80%;
        height:100px;
        border:1px solid #999;
        border-radius:20px;
    }

    
</style>