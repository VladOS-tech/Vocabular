<template>
    <div class="phrases-page-main-grid">
        <div class="sort-area">
            <sortingSelection />
        </div>
        <!-- Add loading and load phrases from array -->
        <loadingIcon v-if="isLoading.phrases" />
        <div class="phrase-area" v-else>
            <phraseBlock v-for="phrase in phrasesList" :key="phrase.id" :PhraseData="phrase" />
        </div>
        <div class="sidebar-area">
            <helpBlock />
            <SidebarTags/>
        </div>
    </div>
</template>

<script lang="ts">
import sortingSelection from '@/components/Misc/SortingSelection.vue'
import phraseBlock from '@/components/Blocks/PhraseBlock.vue';
import helpBlock from '@/components/SidePanel/HelpBlock.vue';
import SidebarTags from '@/components/SidePanel/SidebarTags.vue';
import loadingIcon from '@/components/Misc/LoadingIcon.vue';
import { defineComponent } from 'vue';
import { mapMutations, mapState, mapActions, mapGetters } from 'vuex';

export default defineComponent({
    components:{
        sortingSelection,
        phraseBlock,
        helpBlock,
        SidebarTags,
        loadingIcon
    },
    data(){
        return{
            pageName: 'Словарь Фразеологизмов' as string
        }
    },
    computed:{
        ...mapGetters(['isLoading', 'phrasesList', 'SidebarTags']),
    },
    methods:{
        ...mapMutations(['setPageName']),
        ...mapActions(['GetPhrasesInfo', 'UserPageLoadAllInfo'])
    },beforeMount(){
        this.UserPageLoadAllInfo()
    },
    mounted(){
        this.setPageName(this.pageName)
    },
})
</script>

<style scoped>
@import url('@/assets/style/pages/phrases-screen.css');
</style>