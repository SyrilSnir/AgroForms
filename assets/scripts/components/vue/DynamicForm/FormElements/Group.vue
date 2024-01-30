<template>
<div class="group-block">
        <h3>{{ title }}</h3>
        <template v-for="elem in fields">
                <el :lang="lang" :unitData="elem" @modification="fieldChanged" :dic="dic"></el>
        </template>
</div>
</template>
<script>
import Element from "./Element";
export default {
    components: {
        el: Element
    },        
    props: [
        'exhibitionId',
        'fields',
        'title',
        'lang',
        'dic'
    ],
    methods: {
        fieldChanged(field) {
            this.$emit('modification', field);
        }            
    }   
}
</script>
<style></style>