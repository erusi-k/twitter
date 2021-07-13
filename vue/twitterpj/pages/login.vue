<template>
    <div>
        <h2>ログイン</h2>
        <input type="email" v-model="email" placeholder="メールアドレス" >
        <input type="password" v-model="password" placeholder="パスワード">
        <button @click="login">ログイン</button>
    </div>
</template>

<script>
import firebase from '~/plugins/firebase'
export default {
    data(){
        return{
            emali:null,
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