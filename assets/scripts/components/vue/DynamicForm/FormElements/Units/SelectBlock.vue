<template>
<div class="form-group">
    <label class="control-label">{{ titleLabel }}</label>
    <select  @change="change" :name="id" :id="id" class="form-control" v-model="selected">
        <option v-for="element in enums" :value="element.value">{{ getName(element.name, element.name_eng) }}</option>
    </select>
    <div class="field__desc">{{ descriptionLabel }}</div>
</div>

</template>
<script>
import { unitMixin } from './Mixins/unitMixin';
import { selectMixin } from './Mixins/selectMixin';
import { computedMixin } from './Mixins/computedMixin';  
import { labelMixin } from './Mixins/labelMixin'
import { textTranslateMixin } from './Mixins/textTranslateMixin';
export default {
        props: [
            'lang'
        ],     
       data() {
           return {
                id: 'id' + this.params.id,
                valid: true,
                selected: this.params.value              
           }
       },  
       computed: {
           total() {
               if (!this.isComputed) {
                   return 0;
               }
               return  +this.selected;
           }
       },       
       created() {
           this.$emit('changeField',this.getData());
       },
        methods: {
           change() {
               this.params.value = this.selected;
                this.$emit('changeField',this.getData());               
           },            
           getData() {
               let data = {
                   id: this.id,
                   data:  {
                       value: this.selected,                       
                    },
                   valid: this.valid                   
               }
                if (this.isComputed) {
                   data.computed = true;
                   data.total = this.total;
               }
               return data;
           }
        },
       mixins: [
           unitMixin,
           selectMixin,
           computedMixin,
           labelMixin,
           textTranslateMixin           
       ],    
}
</script>
<style scoped>

</style>