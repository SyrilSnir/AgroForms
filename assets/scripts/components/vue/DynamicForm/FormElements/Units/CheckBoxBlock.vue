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
    export default {
        props: [
            'lang'
        ],         
       data() {
           return {
                id: 'id' + this.params.id,
                checked: this.params.value,
                valid: true                
           }
       },        
       mixins: [
           unitMixin,
           labelMixin
       ],
       created() {
           this.$emit('changeField',this.getData());
       }, 
       methods: {
           change() {
               this.params.value = this.checked;
                this.$emit('changeField',this.getData());               
           },
           getData() {
               return {
                   id: this.id,
                   data:  {
                       value: this.params.value,                       
                    },
                   valid: this.valid                   
               }
           }
       }      
    }
</script>
<style></style>