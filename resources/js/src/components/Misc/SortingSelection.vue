<template>
    <div class="sort-button-container sort-button-container-light">
        <div class="sort-button button" @click="showOptions = !showOptions">
        <img :src="getIcon(selectedOption?.icon as string)" alt="sort">
        {{selectedOption?.displayName}}
        </div>
        <div ref="sortOptionsHoverArea" v-show="showOptions" class="sort-options-hover-area" @click.self="showOptions = false" @mouseleave="showOptions = false">
            <div class="sort-options-panel sort-options-panel-light">
                <div v-for="option in notSelectedOptions" :key="option.name" class="sort-button button" @click="changeSelectedOption(option.name); showOptions = false">
                    <img :src="getIcon(option.icon)" alt="sort">
                    {{ option.displayName }}
                </div>
            </div>
        </div>
    </div>
</template>

<!-- this should emit event to main page and there dispatched event to request ordered elements from database -->

<script lang="ts">
    import { defineComponent } from 'vue';
    import { mapActions, mapGetters, mapMutations } from 'vuex';
    import SortingOption from '@/assets/interfaces/SortingOptions';
    import sortingOptionsJSON from '@/assets/JSObjects/SortingOptions.json'
    
    export default defineComponent({
        data(){
            return{
                sortingOptions: sortingOptionsJSON as SortingOption[],
                selectedOption: undefined as SortingOption | undefined,
                showOptions: false as boolean
            }
        },
        computed:{
            ...mapGetters(['sortingOption']),
            notSelectedOptions(): SortingOption[]{
                return this.sortingOptions.filter(el => { return el.name != this.selectedOption?.name })
            }
        },
        beforeMount(){
            this.selectedOption = this.sortingOptions[0]
            this.setSortingOption(this.selectedOption.name)
            // console.log(this.selectedOption?.icon);
        },
        methods: {
            ...mapMutations(['setSortingOption']),
            getIcon(img: string){
                return require(`@/assets/images/icons/`+img)
            },
            changeSelectedOption(name: string){
                this.selectedOption = this.sortingOptions.find(e => e.name === name)
                this.setSortingOption(this.selectedOption?.name)
                this.GetPhrasesInfo()
            },
            ...mapActions(['GetPhrasesInfo'])
        }
    })
</script>

<style scoped>
    @import url('@/assets/style/sorting-styles.css');
</style>