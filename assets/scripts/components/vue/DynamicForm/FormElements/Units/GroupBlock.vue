<template>
   <div class="block__group">
      <h2 v-if="showTitle">{{ titleLabel }}</h2>
        <template v-for="elem in elements">
            <el :lang="lang" :unitData="elem" @modification="fieldChanged" :dic="dic"></el>
        </template>         
   </div> 
</template>
<script>
import { labelMixin } from './Mixins/labelMixin'
import Element from "../ElementInGroup.vue";
export default {
      data() {
         return {
               id: 'id' + this.params.id,
               fields: {},
               valid: true                
         }
      },    
    components: {
         el: Element,
    },
   created() {
         //  this.$emit('changeField',this.getData());
   },    
    props: [
        'params',
         'lang',
         'dic'
    ],                                           
    mixins: [
         labelMixin
    ],      
    computed: {
         showTitle() {
            return false;
         },
         elements() {
            return this.params.parameters.elements;
         }
    },
    methods: {
         fieldChanged(field) {
               this.$emit('changeField',field);     
      },
    }     
}
</script>
<style scope>
    h2 {
      color: firebrick;
   }
</style>