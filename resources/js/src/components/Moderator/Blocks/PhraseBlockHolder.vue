<template>
    <div class="request-block">
        <loadingIcon v-if="phraseLoading" />
        <phraseItemModer v-for="phrase in phrasesList" :key="phrase.id" :PhraseData="phrase" />
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import phraseItemModer from '@/components/Moderator/Blocks/PhraseItemModer.vue';
import LoadingIcon from '@/components/Misc/LoadingIcon.vue';
import { mapActions, mapGetters, mapMutations } from 'vuex';

    export default defineComponent({
        components:{
            phraseItemModer,
            LoadingIcon
        },
        computed:{
            ...mapGetters(['phraseLoading', 'requestList', 'phrasesList'])
        },
        methods:{
            ...mapMutations(['setTabName']),
            ...mapActions(['GetPhraseInfoModerator'])
        },
        mounted(){
            this.setTabName('phrases')
            this.GetPhraseInfoModerator()
        }
    })
</script>

<style scoped>
    @import url('@/assets/style/moderator/elements/requests.css');
</style>

