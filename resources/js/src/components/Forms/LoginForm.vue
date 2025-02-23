<template>
    <div class="login-form login-form-light">
        <h2>
            Авторизация
        </h2>
        <div class="separator-line"/>
        <div class="login-field-holder">
            <h4>Email/Telegram:</h4>
            <input type="text" class="input-field input-field-regular" v-model="login">
        </div>
        <div class="login-field-holder">
            <h4>Пароль:</h4>
            <input type="password" class="input-field input-field-regular" v-model="password">
        </div>
        <button class="button button-large login-button">
            Вход
        </button>
    </div>
</template>

<script lang="ts">
    import { defineComponent } from 'vue'

    export default defineComponent({
        data(){
            return{
                login: '' as string,
                password: '' as string
            }
        }
    })
</script>

<style scoped>
    @import url('@/assets/style/forms/login-form.css');
</style>