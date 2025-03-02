<template>
    <div class="moderator-main-grid">
        <div class="sort-area">
            <sortingSelectionModerator/>
                <form action="-IDK-" class="search-block">
                <input id="search-field-moderator-id" type="text" class="moderator-search-field moderator-search-field-light" placeholder="Поиск" v-model="searchInput"/>
                <label for="search-field-moderator-id">
                    <img src="@/assets/images/icons/search-icon.svg" alt="search-icon" class="search-icon-header search-icon-header-light">
                </label>
            </form>
        </div>
        <div class="tabs-area">
            <router-link :class="tabName=='requests' ? 'tab-selected' : 'tab-unselected'" class="tab-style button tab-button" to="/moderator/requests">Запросы на добавление</router-link>
            <div class="tabs-vertical-separator">
            </div>
            <router-link :class="tabName=='phrases' ? 'tab-selected' : 'tab-unselected'" class="tab-style button tab-button" to="/moderator/phrases">Фразеологизмы</router-link>
            <div class="tabs-vertical-separator">
            </div>
            <router-link to="moderator/add" class="button tab-button tab-add-button link-style">Добавить</router-link>
        </div>
        <div class="request-area">
            <router-view/>
        </div>
    </div>
</template>

<script lang="ts">

import { defineComponent } from 'vue'
import { mapGetters, mapMutations } from 'vuex';
import sortingSelectionModerator from '@/components/Moderator/Misc/SortingSelectionModerator.vue';

export default defineComponent({

        components: {
            sortingSelectionModerator
        },
        data() {
            return{
                pageName: 'Модерация' as string,
                searchInput: '' as string
            }
        },
        computed:{
            ...mapGetters(['tabName'])
        },
        methods:{
            ...mapMutations(['setPageName', 'setTabName'])
        },
        mounted(){

            // Перенести в компоненте переназначение тега

            this.setPageName(this.pageName)
        }
})

</script>

<style scoped>
    @import url('@/assets/style/moderator/moderator-main.css');
</style>