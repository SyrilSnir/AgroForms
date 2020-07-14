<template>
<div class="group-block">
        <h3>{{ title}}</h3>
        <template v-for="elem in fields">
                <el :unitData="elem" @modification="fieldChanged"></el>
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
        'fields',
        'title'
    ],
    methods: {
        fieldChanged(field) {
            this.$emit('modification', field);
        }            
    }   
}
</script>
<style></style>