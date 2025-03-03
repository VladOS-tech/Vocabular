<template>
    <header class="light-header-colors header-class">
        <router-link to="/" class="link-style">
            <h1>
                {{ pageName }}
            </h1>
        </router-link>
        <form class="search-block" :class="{'mobile-search-block-active': isMobile && isSearchActive, 'search-block-inactive-mobile': !isSearchActive || !isMobile}">
            <input id="search-field-id" type="text" class="user-search-field user-search-field-light" placeholder="Поиск" v-model="searchInput" @keypress.enter="search" @focus="isSearchActive = true" @blur="isSearchActive = false"/>
            <label for="search-field-id">
                <img src="@/assets/images/icons/search-icon.svg" alt="search-icon" class="search-icon-header search-icon-header-light">
            </label>
            <router-link class="button plus-button-header button-large link-style" to="/add">
                <img src="@/assets/images/icons/plus-icon.svg" alt="search-icon" class="plus-icon-header">
            </router-link>   
        </form>
    </header>
</template>

<script lang="ts">
    import { defineComponent } from 'vue';
    import { mapGetters, mapActions, mapMutations } from 'vuex';

    export default defineComponent({
        data(){
            return{
                isSearchActive: false as boolean,
                searchInput: '' as string
            }
        },
        computed:{
            ...mapGetters(['pageName', 'isMobile'])
        },
        methods:{
            ...mapMutations(['setSearchRequest']),
            ...mapActions(['SearchPhrasesInBd', 'GetPhrasesInfo']),
            search(e: Event){
                e.preventDefault()
                this.setSearchRequest(this.searchInput)
                this.GetPhrasesInfo()
            }
        }
    }) 
</script>

<style scoped>
    @import url('@/assets/style/headers/user-header.css');
</style>