<template>
    <div class="input-tags-block">
        <h3>
            Теги:
        </h3>
        <div class="tag-input-wrapper" @click="($refs.tagField as HTMLInputElement).focus">
            <div class="tag tag-generic tag-editable" @click.stop v-for="tag in tags" :key="tag">
                {{ tag }}
                <button class="button remove-tag-button" @click="removeTag(tag)">
                    x
                </button>
            </div>
            <div contenteditable class="tag-hidden-input" type="text" ref="tagField" @input="checkTags">{{ tagInput }}</div>
        </div>
    </div>
</template>

<script lang="ts">
    import { defineComponent } from 'vue';
import { mapGetters, mapMutations } from 'vuex';

    export default defineComponent({
        data(){
            return{
                tagInput: '' as string,
                tags: new Set<string>()
            }
        },
        methods:{
            ...mapMutations(['setInputTags', 'setInputTagsError']),
            checkTags(e: Event){
                this.tagInput = (e.target as HTMLElement)?.innerText;
                console.log(this.tagInput.split(',')[0].trim())
                if(this.tagInput.indexOf(',') !== -1){
                    const newTag = this.tagInput.split(',')[0].trim();
                    if(newTag.length !== 0) {
                        this.tags.add(newTag);
                        this.setInputTags(this.tags)
                    }
                    this.tagInput = '';
                    (e.target as HTMLElement).innerText = ''
                }
            },
            removeTag(tag: string){
                this.tags.delete(tag)
                this.setInputTags(this.tags)
            },
            beforeMount() {
                this.setInputTags([])
            }
        }
    })

</script>

<style scoped>
    @import url('@/assets/style/forms/form-components/input-tags.css');
</style>