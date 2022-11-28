<template>
<div class="form-group">
    <select  @change="change" :name="id" :id="id" class="form-control" multiple v-model="selected">
        <option v-for="element in enums" :value="element.id">{{ element.name }}</option>
    </select>
    <div class="field__desc">{{ descriptionLabel }}</div>
    <div v-if="isComputed" class="field__price"><span class="price">{{ total }}</span> {{ dic.valute }}</div>
</div>

</template>
<script>
import { unitMixin } from './Mixins/unitMixin';
import { selectMixin } from './Mixins/selectMixin';
import { computedMixin } from './Mixins/computedMixin';
import { labelMixin } from './Mixins/labelMixin';
import { textTranslateMixin } from './Mixins/textTranslateMixin';
export default {
        props: [
            'lang','dic'
        ],     
       data() {
           let val = Array.isArray(this.params.value) ? this.params.value : []
           return {
                id: 'id' + this.params.id,
                valid: true,
                selected: val
           }
       }, 
       computed: {
           total() {
               if (!this.isComputed) {
                   return 0;
               }
               let total = 0;
               for (const el of this.enums) {
                   if(this.selected.indexOf(el.id) >= 0) {
                        total+= +el.value;
                   }
               }
               return  total;
           }
       },           
       created() {
           this.$emit('changeField',this.getData());
       },           
       mixins: [
           unitMixin,
           selectMixin,
           computedMixin,
           labelMixin,
           textTranslateMixin
       ],
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
       }    
}
</script>
<style scoped>
    .field__price {
        text-align: right;
    }
</style>