<template>
  <router-view name="nav"></router-view>
  <router-view></router-view>
</template>

<script lang="ts">
  
import { defineComponent } from 'vue';
import store from '@/store/index';
  export default {
    mounted(){
      if(window.innerWidth <= 768){
        store.commit('setMobile', true);
      }
      else store.commit('setMobile', false);
    }
  }
</script>

<style>
@import url("../src/assets/style/global-styles.css");
</style>
