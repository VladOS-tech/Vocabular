<template>
    <div class="request-block">
        <loadingIcon v-if="staffLoading" />
        <staffItemAdmin v-for="staff in staffList" :key="staff.id" :StaffData="staff" />
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import staffItemAdmin from './StaffItemAdmin.vue';
import LoadingIcon from '@/components/Misc/LoadingIcon.vue';
import { mapActions, mapGetters, mapMutations } from 'vuex';

    export default defineComponent({
        components:{
            staffItemAdmin,
            LoadingIcon
        },
        computed:{
            ...mapGetters(['staffLoading', 'staffList'])
        },
        methods:{
            // ...mapMutations(['setTabName']),
            ...mapActions(['GetStaffInfoAdministrator'])
        },
        mounted(){
            // this.setTabName('phrases')
            this.GetStaffInfoAdministrator()
        }
    })
</script>

<style scoped>
    @import url('@/assets/style/moderator/elements/requests.css');
</style>

