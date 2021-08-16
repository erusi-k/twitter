<template>
    <div class="register">
        <div class="register-menu">
            <h2>新規登録</h2>
            <div class="register-menu-area">
                <validation-observer ref="obs" v-slot="ObserverProps">
                    <validation-provider v-slot="ProviderProps" rules="required|max:20">
                        <input type="text" v-model="userName" placeholder="ユーザーネーム" name="ユーザーネーム">
                        <div class="error">{{ProviderProps.errors[0]}}</div>
                    </validation-provider>
                    <validation-provider v-slot="ProviderProps" rules="required|email">
                        <input type="email" v-model="email" placeholder="メールアドレス" name="メールアドレス">
                        <div class="error">{{ProviderProps.errors[0]}}</div>
                    </validation-provider>
                    <validation-provider v-slot="ProviderProps" rules="required|min:6">
                        <input type="password" v-model="password" placeholder="パスワード" name="パスワード">  
                        <div class="error">{{ProviderProps.errors[0]}}</div>
                    </validation-provider>    
                    <button class="btn" @click="register" :disabled="ObserverProps.invalid ||!ObserverProps.validated">新規登録</button>
                </validation-observer>
            </div>
        </div>
        
    </div>
</template>

<script>

import firebase from '~/plugins/firebase'
export default {
    layout:'top',
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
                    alert('新規登録が完了しました！');
                    this.$router.push('login');

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

<style scoped>

    .register{
        width:100%;
    }

    .register-menu{
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