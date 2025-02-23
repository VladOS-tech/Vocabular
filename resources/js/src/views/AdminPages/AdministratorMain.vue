<template>
    <div class="admin-main-grid">
        <div class="sort-area">
                <form action="-IDK-" class="search-block">
                <input id="search-field-moderator-id" type="text" class="admin-search-field admin-search-field-light" placeholder="Поиск" v-model="searchInput"/>
                <label for="search-field-moderator-id">
                    <img src="@/assets/images/icons/search-icon.svg" alt="search-icon" class="search-icon-header search-icon-header-light">
                </label>
            </form>
        </div>
        <div class="tabs-area">
            <div class="tab-style tab-button" to="/admin/staff">Персонал</div>
        </div>
        <div class="request-area">
            <router-view/>
        </div>
    </div>
</template>

<script lang="ts">

import { defineComponent } from 'vue'
import { mapGetters, mapMutations } from 'vuex';

export default defineComponent({

        data() {
            return{
                pageName: 'Администрация' as string,
                searchInput: '' as string
            }
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
    @import url('@/assets/style/administrator/administrator-main.css');
</style>