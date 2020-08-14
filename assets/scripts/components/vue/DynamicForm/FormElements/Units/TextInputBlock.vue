<template>
<div class="form-group" :class="{'required' : required }">
    <label :for="id">{{ titleLabel }}</label>
    <input 
        :id="id"
        type="text" 
        class="form-control"
        :class="{'is-invalid' : hasErrorsForShow() }" 
        v-model="val"
        @change="onChange($event)"
        placeholder="Enter ...">
    <div v-if="hasErrorsForShow()" class="help-block">{{ errors.required.message }}</div>        
</div>
</template>
<script> 
    import { unitMixin } from './Mixins/unitMixin'
    import { labelMixin } from './Mixins/labelMixin'  
    import { eventBus } from '../../eventBus'
    export default {        
        props: [
            'lang'
        ],

       data() {           
           return {
            id: 'id' + this.params.id,
            val: this.params.value,
            showErrors : false,
            valid: true,
            errors : {
                required: {
                    message: "Поле обязательно для заполнения"
                }
            }
           }
       },      
       mixins: [
           unitMixin,
           labelMixin
       ],
       created() {
           this.$emit('changeField',this.getData());
           eventBus.$on('showErrors',() => this.showErrors = true);
           eventBus.$on('validate',() => {
               this.validate()
               this.$emit('changeField',this.getData());
           }
               );
       },
       methods: {
           validate() {
               this.valid = true; // default
               this.currentError = null;
               if(this.val == '') {
                   if (this.required) {
                       this.currentError = this.errors.required;
                       this.valid = false;
                   }
               }
           },            
           hasErrorsForShow() {
               if (!this.showErrors || !this.currentError) {
                   return false;
               }
               return true;

           },
           onChange(event) {
               this.showErrors = false;
               this.$emit('changeField',this.getData());
           },
           getData() {
               return {
                   id: this.id,
                   data:  {
                       value: this.val,                       
                    },
                   valid: this.valid
               }
           }
       } 
    }
</script>
<style></style>