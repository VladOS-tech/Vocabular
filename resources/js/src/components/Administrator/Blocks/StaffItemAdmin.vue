<template>
    <div class="phrase-block phrase-block-light">
        <h2>{{ StaffData.name }}</h2>
        <div class="staff-role" :class="StaffData.role === 'admin' ? 'admin-role' : 'moderator-role'">
            {{ displayRole(StaffData.role) }}
        </div>
        <div class="staff-data-row">
            <h3>Почта:</h3>
            <div v-if="StaffData.email !== null" class="staff-data-field">
                {{StaffData.email}}
            </div>
            <div v-else class="staff-data-field-empty">
                —
            </div>
        </div>
        <div class="staff-data-row">
            <h3>Телеграм:</h3>
            <div v-if="StaffData.telegram !== null"  class="staff-data-field">
                {{StaffData.telegram}}
            </div>
            <div v-else class="staff-data-field-empty">
                —
            </div>
        </div>
        <div class="admin-staff-button">
            <!-- <button class="button button-large remove-phrase-button">
                Удалить
            </button> -->
            <!-- <button class="button button-large edit-staff-button">
                Редактировать
            </button> -->
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, PropType } from 'vue';
import StaffObject from '@/assets/interfaces/StaffObject';

    export default defineComponent({
        props:{
            StaffData: {
                type: Object as PropType<StaffObject>,
                required: true
            }
        },
        methods:{
            displayRole(role: string){
                switch(role){
                    case('admin'):{
                        return 'Администратор'
                    }
                    case('moderator'):{
                        return 'Модератор'
                    }
                    default:{
                        return 'no role'
                    }
                }
            }
        }
    })
</script>

<style scoped>
    @import url('@/assets/style/elements/phrase-style.css');
    @import url('@/assets/style/administrator/elements/staff-item.css');
</style>