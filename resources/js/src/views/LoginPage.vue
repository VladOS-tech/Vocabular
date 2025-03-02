<template>
    <div class="login-container">
        <loginForm/>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import loginForm from '../components/Forms/LoginForm.vue';
import { mapMutations } from 'vuex';

    export default defineComponent({
        components:{
            loginForm
        },
        data() {
            return{
                pageName: 'Авторизация' as string
            }
        },
        methods:{
            ...mapMutations(['setPageName'])
        },
        mounted(){
            this.setPageName(this.pageName)
        }
    })
</script>

<style scoped>
    @import url('/src/assets/style/pages/login-page.css');
</style>