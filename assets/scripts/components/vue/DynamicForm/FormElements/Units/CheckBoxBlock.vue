<template>
<div class="form-group">
    <div class="custom-control custom-checkbox">
        <input @change="change" class="custom-control-input" type="checkbox" :id="id" v-model="checked">
        <label :for="id" class="custom-control-label">{{ titleLabel }}</label>
    </div>
</div>
</template>
<script>
    import { unitMixin } from './Mixins/unitMixin'
    import { labelMixin } from './Mixins/labelMixin'
    import { computedMixin } from './Mixins/computedMixin'
    export default {
        props: [
            'lang'
        ],         
       data() {
           return {
                id: 'id' + this.params.id,                 
                checked: this.params.checked,
                valid: true                
           }
       },        
       mixins: [
           unitMixin,
           computedMixin,
           labelMixin
       ],
       created() {
           this.$emit('changeField',this.getData());
       }, 
       computed: {
           total() {
               if (!this.isComputed || !this.checked) {
                   return 0;
               }
               return +this.unitPrice;
           }
       },       
       methods: {
           change() {
               this.params.value = this.checked;
                this.$emit('changeField',this.getData());               
           },
           getData() {
               let data = {
                   id: this.id,
                   data:  {
                       value: this.unitPrice, 
                       checked: this.checked                     
                    },
                   valid: this.valid,
                   checkbox: true,                  
               };
                if (this.isComputed) {
                   data.computed = true;
                   data.total = this.total;
               }
               return data;               
           }
       }      
    }
</script>
<style></style>