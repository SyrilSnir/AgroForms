<template>
<h3>{{ parameters.text}}</h3>
</template>
<script>
    import { unitMixin } from './Mixins/unitMixin';
    export default {
       mixins: [
           unitMixin
       ]
    }
</script>
<style></style>