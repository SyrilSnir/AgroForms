<template>
<div class="important" v-html="title"></div>
</template>
<script>
    import { unitMixin } from './Mixins/unitMixin'
    import { languages } from '../../../lang'
    export default {
        props: [
            'lang'
        ],
       mixins: [
           unitMixin
       ],
       computed: {
           title() {
               // this.parameters.html
               if (this.lang == languages.russian || !this.parameters.textEng) {
                   return this.parameters.text;
               }
               return this.parameters.textEng;
           }
       }
    }
</script>
<style></style>