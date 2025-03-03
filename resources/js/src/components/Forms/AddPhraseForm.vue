<template>
    <div class="add-phrase-block add-phrase-block-light">
        <h2>Заполните указанные поля</h2>
        <div class="separator-line"/>

        <textarea type="text" class="input-field input-field-header input-field-textarea" 
                  placeholder="Введите новый фразеологизм"
                  @input="heightResize" 
                  @blur="updateInputPhrase" 
                  rows="1" 
                  v-model="inputPhrase">
        </textarea>
        <div class="input-error">
            {{ inputPhraseError }}
        </div>  
        <InputTags/>
        <div class="input-error">
            {{ inputTagsError }}
        </div>

        <inputMeanings/>

        <div class="buttons-block">
            <button class="button button-large confirm-meaning-button" 
                    :disabled="isLoading.inputPhrase"
                    @click="checkInput">
                Готово
            </button>
            <router-link to="/" class="button button-large cancel-meaning-button link-style">
                Отмена
            </router-link>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted, computed } from 'vue';
import { useStore } from 'vuex';
import inputMeanings from './FormComponents/InputMeanings.vue';
import InputTags from './FormComponents/InputTags.vue';

export default defineComponent({
    components: { inputMeanings, InputTags },
    setup() {
        const store = useStore();
        const inputPhrase = ref('');
        const selectedTags = ref<number[]>([]);

        onMounted(() => {
            store.dispatch('GetPopularTags'); // Загружаем теги с бэкенда
            store.commit('setInputPhrase', ''); // Очищаем поле при монтировании
        });

        const tagsList = computed(() => store.getters.popularTags);
        const inputPhraseError = computed(() => store.getters.inputPhraseError);
        const inputTagsError = computed(() => store.getters.inputTagsError);
        const isLoading = computed(() => store.getters.isLoading);

        const heightResize = (e: Event) => {
            const textField = e.target as HTMLTextAreaElement;
            textField.style.height = '0px';
            textField.style.height = textField.scrollHeight + 'px';
        };

        const updateInputPhrase = () => {
            store.commit('setInputPhrase', inputPhrase.value);
        };

        const checkInput = async () => {
            store.commit('setLoading', { whichLoading: 'inputPhrase', newLoading: true });
            store.commit('setInputTags', selectedTags.value); // Сохраняем выбранные теги
            await store.dispatch('CheckPhraseInput');
            store.commit('setLoading', { whichLoading: 'inputPhrase', newLoading: false });
        };

        return {
            inputPhrase,
            selectedTags,
            tagsList,
            inputPhraseError,
            inputTagsError,
            isLoading,
            heightResize,
            updateInputPhrase, // Исправленный метод обновления фразы
            checkInput
        };
    }
});
</script>

<style scoped>
    @import url('@/assets/style/forms/add-phrase-form.css');
</style>
