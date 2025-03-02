<template>
    <div class="login-form login-form-light">
        <h2>Авторизация</h2>
        <div class="separator-line"/>
        <div class="login-field-holder">
            <h4>Email/Telegram:</h4>
            <input type="text" class="input-field input-field-regular" v-model="email">
        </div>
        <div class="login-field-holder">
            <h4>Пароль:</h4>
            <input type="password" class="input-field input-field-regular" v-model="password">
        </div>
        <button class="button button-large login-button" @click="loginUser">
            Вход
        </button>
    </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'
import { useStore } from 'vuex'

export default defineComponent({
    setup() {
        const store = useStore() // Подключаем store
        const email = ref('')
        const password = ref('')

        const loginUser = async () => {
            try {
                await store.dispatch('loginUser', {
                    email: email.value,
                    password: password.value
                })
            } catch (error) {
                console.error('Ошибка входа:', error)
            }
        }

        return { email, password, loginUser }
    }
})
</script>

<style scoped>
@import url('@/assets/style/forms/login-form.css');
</style>
