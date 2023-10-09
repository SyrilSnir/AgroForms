<template>
<div class="form-group">
    <label class="control-label">{{ titleLabel }}</label>
    <select  @change="change" :name="id" :id="id" class="form-control" v-model="selected">
        <option v-for="element in enums" :value="element.id">{{ getName(element.name, element.name_eng) }}</option>
    </select>
    <div class="field__desc">{{ descriptionLabel }}</div>
    <div v-if="isComputed" class="field__price"><span class="price">{{ total }}</span> {{ dic.valute }}</div>
</div>

</template>
<script>
import { unitMixin } from './Mixins/unitMixin';
import { selectMixin } from './Mixins/selectMixin';
import { computedMixin } from './Mixins/computedMixin';  
import { labelMixin } from './Mixins/labelMixin'
import { textTranslateMixin } from './Mixins/textTranslateMixin';
import { numberFormatMixin } from './Mixins/numberFormatMixin';

export default {
        props: [
            'lang','dic'
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
               let total = 0;
               if (!this.isComputed) {
                   return total;
               }               
               for (const el of this.enums) {
                   if (el.id == this.selected) {
                       total = +el.value;
                   }                   
                }
               if (isNaN(total)) {
                   return 0;
               }
               return total;
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
           textTranslateMixin,
           numberFormatMixin        
       ],    
}
</script>
<style scoped>
    .field__price {
        text-align: right;
    }
</style>