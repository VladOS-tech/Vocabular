<template>
    <div>
        <addPhraseForm/>
    </div>
</template>

<script lang="ts">
    import { defineComponent } from 'vue';
    import { mapMutations } from 'vuex';
    import addPhraseForm from '@/components/Forms/AddPhraseForm.vue';

    export default defineComponent({
        components:{
            addPhraseForm
        },
        data(){
            return{
              pageName: 'Добавить' as string  
            }
        },
        methods:{
            ...mapMutations(['setPageName'])
        },
        mounted(){
            this.setPageName(this.pageName);
        },
    })
</script>

<style>
    @import url('@/assets/style/pages/add-phrase.css');
</style>