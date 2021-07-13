<template>
    <div>
        <h2>新規登録</h2>
        <input type="text" v-model="userName" placeholder="ユーザーネーム">
        <input type="email" v-model="email" placeholder="メールアドレス">
        <input type="password" v-model="password" placeholder="パスワード">
        <button @click="register">登録する</button>
        
    </div>
</template>

<script>
import firebase from '~/plugins/firebase'
export default {
    data(){
        return {
            userName:null,
            email:null,
            password:null
        }
    },
    methods:{
        register(){
            if(!this.email || !this.password) {
                alert('未入力箇所があります。')
                return 
            }
            firebase.auth().createUserWithEmailAndPassword(this.email,this.password).then((data) => {
                data.user.sendEmailVerification().then(async ()=>  {
                    const sendData = {
                        user:this.userName,
                        email:this.email
                    };
                    await this.$axios.post("http://127.0.0.1:8000/api/user/",sendData);
                    
                    //登録完了表示、ログイン画面に転送
                })
        
            })
        
            .catch((error) => {
            switch (error.code) {
                case 'auth/invalid-email':
                alert('メールアドレスの形式が違います。')
                break
                case 'auth/email-already-in-use':
                alert('このメールアドレスはすでに使われています。')
                break
                case 'auth/weak-password':
                alert('パスワードは6文字以上で入力してください。')
                break
                default:
                alert('エラーが起きました。しばらくしてから再度お試しください。')
                break
            }
        })
        },

        }
    }

</script>