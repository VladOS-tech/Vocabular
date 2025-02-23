<template>
    <div class="input-meanings-block">
        <div class="input-meaning-block" v-for="(meaning, index) in meanings" :key="index">
            <div class="input-meaning-block-content">
                <h3>
                    Значение:
                </h3>
                <textarea ref="'meaning'+ index" type="text" class="input-field input-field-regular input-field-textarea" placeholder="Введите значение фразеологизма..."
                @input="heightResize" @blur="setInputMeanings(meanings)" rows="1" v-model="meaning.meaning"></textarea>
        <div class="input-error">
            {{inputMeaningsErrors.at(index)?.meaning}}
        </div>
                <h3>
                    Применение:
                </h3>
                <textarea ref="'example'+ index" type="text" class="input-field input-field-regular input-field-textarea" placeholder="Приведите пример использования для текущего значения..."
                @input="heightResize" @blur="setInputMeanings(meanings)" rows="1" v-model="meaning.example"></textarea>
        <div class="input-error">
            {{inputMeaningsErrors.at(index)?.example}}
        </div>
            </div>
            <button class="button delete-button button-large" v-if="meanings.length > 1" @click="meanings.splice(index, 1); setInputMeanings(meanings)">
                <img src="@/assets/images/icons/trash-icon.svg" alt="delete">
            </button>
        </div>
        <button class="button button-large add-meaning-button" v-if="meanings.length < 5" @click="meanings.push({meaning: '',example: ''}); setInputMeanings(meanings)">
            <img src="@/assets/images/icons/plus-icon.svg" alt="plus">
            Новое значение
        </button>
    </div>
</template>

<script lang="ts">
    import { defineComponent } from 'vue';
    import MeaningObject from '@/assets/interfaces/MeaningObject';
import { mapGetters, mapMutations } from 'vuex';

    export default defineComponent({
        data(){
            return{
                meanings: [{
                    meaning: '',
                    example: ''
                }] as MeaningObject[]
            }
        },
        computed:{
            ...mapGetters(['inputMeaningsErrors'])
        },
        methods:{
            ...mapMutations(['setInputMeanings', 'setInputMeaningsErrors']),
            heightResize(e: Event){
                console.log('a')
                const textField = e.target as HTMLTextAreaElement
                textField.style.height = '0px'; 
                textField.style.height = textField.scrollHeight + 'px'
            }
        },
        beforeMount(){
            this.setInputMeanings([{meaning: '', example: ''}])
            this.setInputMeaningsErrors([{meaning: '', example: ''}])
        }
    })

</script>

<style scoped>
    @import url('@/assets/style/forms/form-components/input-meanings.css');
</style>