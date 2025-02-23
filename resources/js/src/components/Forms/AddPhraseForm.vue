<template>
    <div class="add-phrase-block add-phrase-block-light">
        <h2>
            Заполните указанные поля
        </h2>
        <div class="separator-line"/>
        <textarea type="text" class="input-field input-field-header input-field-textarea" placeholder="Введите новый фразеологизм"
        @input="heightResize" @blur="setInputPhrase(inputPhrase)" rows="1" v-model="inputPhrase"></textarea>
        <div class="input-error">
            {{ inputPhraseError }}
        </div>
        <inputTags/>
        <div class="input-error">
            {{ inputTagsError }}
        </div>
        <inputMeanings/>
        <div class="buttons-block" @click="checkInput">
            <button class="button button-large confirm-meaning-button" :disabled="isLoading.inputPhrase">
            Готово
        </button>
        <router-link to="/" class="button button-large cancel-meaning-button link-style">
            Отмена
        </router-link>
        </div>
    </div>
</template>

<script lang="ts">
    import { defineComponent } from 'vue';
    import inputTags from './FormComponents/InputTags.vue';
    import inputMeanings from './FormComponents/InputMeanings.vue';
    import { mapActions, mapGetters, mapMutations } from 'vuex';

    export default defineComponent({
        data(){
            return{
                inputPhrase: '' as string
            }
        },
        components:{
            inputTags,
            inputMeanings
        },
        computed:{
            ...mapGetters(['inputPhraseError', 'inputTagsError', 'isLoading'])
        },
        methods:{
            ...mapActions(['CheckPhraseInput']),
            ...mapMutations(['setInputPhrase', 'setInputPhraseError', 'setLoading', 'setInputTagsError']),
            heightResize(e: Event){
                console.log('a')
                const textField = e.target as HTMLTextAreaElement
                textField.style.height = '0px'; 
                textField.style.height = textField.scrollHeight + 'px'
            },
            async checkInput(){
                this.setLoading({ whichLoading: 'inputPhrase', newLoading: true })
                await this.CheckPhraseInput()
                this.setLoading({ whichLoading: 'inputPhrase', newLoading: false })
            }
        },
        beforeMount(){
            this.setLoading({ whichLoading: 'inputPhrase', newLoading: false })
            this.setInputPhrase('')
            this.setInputPhraseError('')
            this.setInputTagsError('')
        }
    })

</script>

<style scoped>
    @import url('@/assets/style/forms/add-phrase-form.css');
</style>