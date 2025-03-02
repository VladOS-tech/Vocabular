<template>
    <div class="phrase-block phrase-block-light">
        <p class="post-date post-date-light">
            {{dateToString(PhraseData.date)}}
        </p>
        <h2>{{ PhraseData.phrase }}</h2>
        <div class="tags-block">
            <div class="tag tag-generic" v-for="tag in PhraseData.tags" :key="tag.id">{{ tag.content }}</div>
        </div>
        <h3>Значения:</h3>
        <div class="meaning-block meaning-block-light" v-for="meaning in PhraseData.meanings" :key="meaning.meaning">
            <h4>{{meaning.meaning}}</h4>
            <p class="meaning-example-text">
                "{{meaning.example}}"
            </p>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, PropType } from 'vue';
import PhraseObject from '@/assets/interfaces/PhraseObject';

    export default defineComponent({
        props:{
            PhraseData: {
                type: Object as PropType<PhraseObject>,
                required: true
            }
        },
        methods:{
            dateToString(date: Date): string{
                if (!date) return "Неизвестно";
                let newDate: RegExpMatchArray | null = date.toString().match(/^(\d{4})-(\d{2})-(\d{2}).*/)
                return `${newDate?.[3]}.${newDate?.[2]}.${newDate?.[1]}`
            }
        }
    })
</script>

<style scoped>
    @import url('@/assets/style/elements/phrase-style.css');
</style>