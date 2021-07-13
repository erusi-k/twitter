import firebase from 'firebase'

if(!firebase.apps.length) {
    firebase.initializeApp({
        apiKey: "AIzaSyDJdLAd20NAvMrSdjwRkYmvBu9S9v39YYs",
    authDomain: "twitterpj-84864.firebaseapp.com",
    projectId: "twitterpj-84864",
    storageBucket: "twitterpj-84864.appspot.com",
    messagingSenderId: "1019450268644",
    appId: "1:1019450268644:web:d9822b6b06e4536efd85f1",
    measurementId: "G-JC7C3T4JHC"
    })
}

export default firebase