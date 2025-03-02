<template>
    <div class="help-block help-block-light">
        <p class="help-text">
            Помогите нам дополнить базу знаний новыми выражениями
        </p>
        <router-link to="/add" class="button button-large button-side link-style">
            Добавить выражение
        </router-link>
    </div>    
</template>

<script lang="ts">
import { defineComponent } from 'vue';

    export default defineComponent({
        
    })
</script>

<style scoped>
    @import url('@/assets/style/elements/help-block.css');
</style>