<template>
    <div class="popular-tags-block popular-tags-block-light">
        <h3>
            Популярные теги
        </h3>
        <!-- make togglable tags(and dispatch event) + hide this menu on mobile and load popular tags via action -->
        <loadingIcon v-if="isLoading.tags" />
        <div class="tags-block" v-else>
            <div class="tag-button" :class="isSelected(tag.id) ? 'tag-selectable-active' : 'tag-selectable'" v-for="tag in Tags" :key="tag.id" ref="tag.id" @click="selectTag(tag.id)">{{ tag.content }}</div>
        </div>
        <div class="button button-large button-side" @click="GetPhrasesInfo()">
            Применить
        </div>
    </div>    
</template>

<script lang="ts">
import { defineComponent, PropType } from 'vue';
import loadingIcon from '../Misc/LoadingIcon.vue';
import TagObject from '@/assets/interfaces/TagObject';
import { mapGetters, mapActions } from 'vuex';

    export default defineComponent({
        data() {
            return{
                selectedTags: new Set<number>()
            }
        },
        props:{
            Tags:{
                type: Object as PropType<TagObject[]>,
                required: true
            }
        },
        components:{
            loadingIcon
        },
        computed:{
            ...mapGetters(['isLoading']),
        },
        methods:{
            ...mapActions(['GetPhrasesInfo']),
            selectTag(tagId: number){
                this.selectedTags.has(tagId) ? this.selectedTags.delete(tagId) : this.selectedTags.add(tagId)
            },
            isSelected(tagId: number): boolean{
                return this.selectedTags.has(tagId)
            }
        }
    })
</script>

<style scoped>
    @import url('@/assets/style/elements/popular-tags.css');
</style>