import { Store } from 'vuex'

import PhraseObject from "@/assets/interfaces/PhraseObject";
import TagObject from "@/assets/interfaces/TagObject";
import LoadingObject from "@/assets/interfaces/LoadingObject";
import MeaningObject from "@/assets/interfaces/MeaningObject";

// temp imports

import ExamplePhrases from '@/assets/JSObjects/ExamplePhrases.json'
import ExampleTags from '@/assets/JSObjects/ExampleTags.json'
import router from "@/router";

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

// ------------
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
    isMobile(state: State) {
        return state.isMobile;
    },
    phrasesList(state: State) {
        return state.phrasesList
    },
    sortingOption(state: State) {
        return state.sortingOption
    },
    popularTags(state: State) {
        return state.popularTags
    },
    isLoading(state: State) {
        return state.isLoading
    },
    inputTagsError(state: State) {
        return state.inputTagsError
    },
    inputMeaningsErrors(state: State) {
        return state.inputMeaningsErrors
    },
    inputPhraseError(state: State) {
        return state.inputPhraseError
    },
    inputTags(state: State) {
        return state.inputTags
    },
    inputMeanings(state: State) {
        return state.inputMeanings
    },
    inputPhrase(state: State) {
        return state.inputPhrase
    }
}
const mutations = {
    setMobile(state: State, isMobile: boolean) {
        state.isMobile = isMobile;
        // console.log(state.isMobile)
    },
    setSortingOption(state: State, newOption: string) {
        state.sortingOption = newOption
    },
    setPhraseList(state: State, newList: PhraseObject[]) {
        state.phrasesList = newList
    },
    setPopularTags(state: State, newTags: TagObject[]) {
        state.popularTags = newTags
    },
    setLoading(state: State, { whichLoading, newLoading }: { whichLoading: keyof LoadingObject, newLoading: boolean }) {
        state.isLoading[whichLoading] = newLoading
    },
    setInputTags(state: State, newTags: Set<string>) {
        state.inputTags = newTags
    },
    setInputMeanings(state: State, newMeanings: MeaningObject[]) {
        state.inputMeanings = newMeanings
    },
    setInputPhrase(state: State, newPhrase: string) {
        state.inputPhrase = newPhrase
    },
    setInputTagsError(state: State, newTagsError: string) {
        state.inputTagsError = newTagsError
    },
    setInputMeaningsErrors(state: State, newMeaningsErrors: MeaningObject[]) {
        state.inputMeaningsErrors = newMeaningsErrors
    },
    setInputPhraseError(state: State, newPhraseError: string) {
        state.inputPhraseError = newPhraseError
    }
}
const actions = {
    // make one action for getting data and store all options inside object + reload tags separately only on page load
    async UserPageLoadAllInfo({dispatch}: {dispatch: any}) {
        dispatch('GetPopularTags')
        dispatch('GetPhrasesInfo')
    },
    async GetPopularTags({commit}: {commit: any}) {
        commit('setLoading', { whichLoading: 'tags', newLoading: true })
        commit('setPopularTags', ExampleTags)
        await new Promise(resolve => {
            setTimeout(resolve, 1000)
        })
        commit('setLoading', { whichLoading: 'tags', newLoading: false })
    },
    async GetPhrasesInfo({commit}: {commit: any}) {
        commit('setLoading', { whichLoading: 'phrases', newLoading: true })
        commit('setPhraseList', ExamplePhrases)
        await new Promise(resolve => {
            setTimeout(resolve, 2000)
        })
        commit('setLoading', { whichLoading: 'phrases', newLoading: false })
    },
    async CheckPhraseInput({ state, commit }: { state: State, commit: any }) {
        let valid = true
        const inputPhrase = state.inputPhrase
        const inputMeanings = state.inputMeanings
        const inputTags = state.inputTags

        if (inputPhrase.length === 0) {
            valid = false
            commit('setInputPhraseError', 'Вы не ввели фразеологизм')
        } else commit('setInputPhraseError', '')

        if (inputTags.size === 0) {
            valid = false
            commit('setInputTagsError', 'Вы не добавили ни одного тега')
        } else commit('setInputTagsError', '')

        const inputErrorsTemp = [] as MeaningObject[];
        inputMeanings.forEach(meaning => {
            let meaningError = ''
            let exampleError = ''
            if (meaning.meaning.length === 0) {
                valid = false
                meaningError = 'Заполните поле значения'
            }
            if (meaning.example.length === 0) {
                valid = false
                exampleError = 'Заполните поле примера'
            }
            inputErrorsTemp.push({ meaning: meaningError, example: exampleError })
        });
        commit('setInputMeaningsErrors', inputErrorsTemp)
        if (!valid) return valid
        await new Promise(resolve => {
            setTimeout(resolve, 1000)
        })
        router.push({ path: '/' })
    }
}

export default { state, getters, mutations, actions }