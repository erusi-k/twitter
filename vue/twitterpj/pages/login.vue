<template>
    <div class="login" >
        <div class="login-menu">
            <h2>ログイン</h2>
                <validation-observer ref="obs" v-slot="ObserverProps">
                    <div class="login-menu_area">
                        <validation-provider v-slot="{errors}" rules="required">
                            <input type="email" name="メールアドレス" v-model="email" placeholder="メールアドレス" >
                            <div class="error">{{errors[0]}}</div>
                        </validation-provider>
                        <validation-provider v-slot="{errors}" rules="required">
                            <input type="password" name="パスワード" v-model="password" placeholder="パスワード">
                            <div class="error">{{errors[0]}}</div>
                        </validation-provider>
                            <button class="btn" @click="login" :disabled="ObserverProps.invalid||!ObserverProps.validated">ログイン</button>       
                    </div>
                </validation-observer>
        </div>
    </div>
</template>

<script>
import firebase from '~/plugins/firebase'
export default {
    layout:'top',
    data(){
        return{
            email:null,
            password:null
        }
    },
    methods:{
        login(){
            if(!this.email || !this.password){
                alert('メールアドレスまたはパスワードが入力されいません')
                return
            }
            firebase.auth().signInWithEmailAndPassword(this.email,this.password).then(() =>{
                alert('ログインが完了しました');
                this.$router.push('home')
            })
            .catch((error) => {
            switch (error.code) {
                case 'auth/invalid-email':
                alert('メールアドレスの形式が違います。')
                break
                case 'auth/user-disabled':
                alert('ユーザーが無効になっています。')
                break
                case 'auth/user-not-found':
                alert('ユーザーが存在しません。')
                break
                case 'auth/wrong-password':
                alert('パスワードが間違っております。')
                break
                default:
                alert('エラーが起きました。しばらくしてから再度お試しください。')
                break
            }
            })
        }
    }
}
</script>

<style scoped>
    

    .login-menu{
        width:40%;
        background-color:#fff;
        text-align:center;
        margin: 100px auto;
        padding-bottom:20px;
    }
    input {
        width:80%;
        height:35px;
        background-color:#fff;
        border-radius:10px;
        border:1px solid #999;
        color:#000;
    }
    input,button {
        display:block;
        margin:10px auto;
    }
    
    
    
</style>