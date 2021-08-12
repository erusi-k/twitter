<template>
<div>
    <div class="header">
        <img src="../img/logo.png">
        <div class="header-menu">
            <NuxtLink class="header_menu_link" to="/register">新規登録</NuxtLink>
            <NuxtLink class="header_menu_link" to="/login">ログイン</NuxtLink>
        </div>
    </div>
    <Nuxt/>
</div>    
</template>

<style>
    img {
        width:80px;
        height:30px;
    }
    
    .header {
        display:flex;
        justify-content: space-between;
    }

    .header_menu_link {
        margin-right: 10px;
    }

    
</style>