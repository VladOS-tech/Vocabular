<template>
    <div class="request-block">
        <loadingIcon v-if="requestLoading" />
        <requestItem v-for="request in requestList" :key="request.id" :RequestData="request" />
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import requestItem from '@/components/Moderator/Blocks/RequestItem.vue';
import LoadingIcon from '@/components/Misc/LoadingIcon.vue';
import { mapActions, mapGetters, mapMutations } from 'vuex';

    export default defineComponent({
        components:{
            requestItem,
            LoadingIcon
        },
        computed:{
            ...mapGetters(['requestLoading', 'requestList'])
        },
        methods:{
            ...mapMutations(['setTabName']),
            ...mapActions(['GetRequestsInfo'])
        },
        mounted(){
            this.setTabName('requests')
            this.GetRequestsInfo()
        }
    })
</script>

<style scoped>
    @import url('@/assets/style/moderator/elements/requests.css');
</style>

