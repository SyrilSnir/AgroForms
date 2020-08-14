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
               if (this.lang == languages.russian || !this.parameters.htmlEng) {
                   return this.parameters.html;
               }
               return this.parameters.htmlEng;
           }
       }
    }
</script>
<style></style>