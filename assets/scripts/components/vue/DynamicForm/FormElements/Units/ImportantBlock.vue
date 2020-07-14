<template>
<div class="important" v-html="this.parameters.html"></div>
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