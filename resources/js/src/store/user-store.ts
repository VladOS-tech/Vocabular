import { Store } from 'vuex'
import axios, { AxiosError } from 'axios'

import PhraseObject from "@/assets/interfaces/PhraseObject"
import TagObject from "@/assets/interfaces/TagObject"
import LoadingObject from "@/assets/interfaces/LoadingObject"
import MeaningObject from "@/assets/interfaces/MeaningObject"
import router from "@/router"

interface State {
    isMobile: boolean;
    sortingOption: string;
    phrasesList: PhraseObject[] | null;
    popularTags: TagObject[] | null;
    isLoading: LoadingObject;
    inputTags: Set<string>;
    inputTagsError: string;
    inputMeanings: MeaningObject[];
    inputMeaningsErrors: MeaningObject[];
    inputPhrase: string;
    inputPhraseError: string;
}

const state: State = {
    isMobile: false,
    sortingOption: '',
    phrasesList: null,
    popularTags: null,
    isLoading: { phrases: true, tags: true, inputPhrase: true },
    inputTags: new Set(),
    inputTagsError: '',
    inputMeanings: [{ meaning: '', example: '' }],
    inputMeaningsErrors: [],
    inputPhrase: '',
    inputPhraseError: ''
}

const getters = {
    isMobile: (state: State) => state.isMobile,
    phrasesList: (state: State) => state.phrasesList,
    sortingOption: (state: State) => state.sortingOption,
    popularTags: (state: State) => state.popularTags,
    isLoading: (state: State) => state.isLoading,
    inputTagsError: (state: State) => state.inputTagsError,
    inputMeaningsErrors: (state: State) => state.inputMeaningsErrors,
    inputPhraseError: (state: State) => state.inputPhraseError,
    inputTags: (state: State) => state.inputTags,
    inputMeanings: (state: State) => state.inputMeanings,
    inputPhrase: (state: State) => state.inputPhrase
}

const mutations = {
    setState<T>(state: State, { key, value }: { key: keyof State, value: T }) {
        state[key] = value as never
    },
    setLoading(state: State, { whichLoading, newLoading }: { whichLoading: keyof LoadingObject, newLoading: boolean }) {
        state.isLoading[whichLoading] = newLoading
    }
}

const actions = {
    async UserPageLoadAllInfo({ dispatch }: { dispatch: any }) {
        await Promise.all([dispatch('GetPopularTags'), dispatch('GetPhrasesInfo')])
    },

    async GetPopularTags({ commit }: { commit: any }) {
        commit('setLoading', { whichLoading: 'tags', newLoading: true })
        try {
            const { data } = await axios.get('http://127.0.0.1:8000/api/tags')
            commit('setState', { key: 'popularTags', value: data })
        } catch (error) {
            console.error('Ошибка при загрузке тегов:', error)
        } finally {
            commit('setLoading', { whichLoading: 'tags', newLoading: false })
        }
    },

    async GetPhrasesInfo({ commit }: { commit: any }) {
        commit('setLoading', { whichLoading: 'phrases', newLoading: true })
        try {
            const { data } = await axios.get('http://127.0.0.1:8000/api/phraseologies')
            commit('setState', { key: 'phrasesList', value: data })
        } catch (error) {
            console.error('Ошибка при загрузке фразеологизмов:', error)
        } finally {
            commit('setLoading', { whichLoading: 'phrases', newLoading: false })
        }
    },

    async CheckPhraseInput({ state, commit }: { state: State, commit: any }) {
         const valid = true

        // Валидация полей
        commit('setState', { key: 'inputPhraseError', value: state.inputPhrase ? '' : 'Вы не ввели фразеологизм' })
        commit('setState', { key: 'inputTagsError', value: state.inputTags.size ? '' : 'Вы не добавили ни одного тега' })

        const inputMeaningsErrors = state.inputMeanings.map(m => ({
            meaning: m.meaning ? '' : 'Заполните поле значения',
            example: m.example ? '' : 'Заполните поле примера'
        }))

        if (!state.inputPhrase || !state.inputTags.size || inputMeaningsErrors.some(m => m.meaning || m.example)) {
            commit('setState', { key: 'inputMeaningsErrors', value: inputMeaningsErrors })
            return
        }

        // Отправка данных
        commit('setLoading', { whichLoading: 'inputPhrase', newLoading: true })
        try {
            await axios.post('http://127.0.0.1:8000/api/phraseologies', {
                phrase: state.inputPhrase,
                meanings: state.inputMeanings,
                tags: Array.from(state.inputTags)
            })
            console.log('✅ Фразеологизм добавлен')

            // Очистка формы
            commit('setState', { key: 'inputPhrase', value: '' })
            commit('setState', { key: 'inputMeanings', value: [{ meaning: '', example: '' }] })
            commit('setState', { key: 'inputTags', value: new Set() })

            router.push('/')
        } catch (error: unknown) {
            const axiosError = error as AxiosError
            console.error('❌ Ошибка при отправке:', axiosError)
            if (axiosError.response) console.error('Ответ сервера:', axiosError.response.data)
        } finally {
            commit('setLoading', { whichLoading: 'inputPhrase', newLoading: false })
        }
    }
}

export default { state, getters, mutations, actions }
