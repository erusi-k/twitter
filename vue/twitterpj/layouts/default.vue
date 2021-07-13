<template>
    <div>
        <div class="layout">
            <h2>SHARE</h2>
            <div class="menu">
                <NuxtLink to="/home"><img class="img" src="../img/home.png" >ホーム</NuxtLink>
                <NuxtLink to="/home"><img class="img" src="../img/logout.png" >ログアウト</NuxtLink>
                <input type="text" v-model="content">
                <button @click="contentShare">シェアする</button>
            </div>
        </div>
        <Nuxt />
    </div>    
</template>

<script>
export default {
    data(){
        return{
            content:null
        }
    },
    methods: {
        async  contentShare(){
            if(!this.content) {
                alert('シェアの内容を入力ください')
                return 
            }
        const sendData = { share: this.content};
        await this.$axios.post('http://127.0.0.1:8000/api/share');
        //page/homeにイベントを投げて、投稿を再レンダリングされる
        }
    }
}
</script>

<style>
    body {
        background-color:aquamarine;
    }

    .layout {
        width:30%;
    }

    .img {
        width:30px;
        height:30px;
    }

    .menu {
        display:flex;
        flex-direction: column;
    }
    
    
</style>