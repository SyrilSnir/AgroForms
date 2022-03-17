<template>
<div class="form-group">
    <label :for="id">{{ titleLabel }}</label>
    <div class="input-group">

        <input 
            :id="id"
            type="text" 
            class="form-control"
            :class="{'is-invalid' : hasErrorsForShow() }" 
            v-model="val"
            @change="onChange($event)"
            placeholder="Enter ...">
        <div 
            v-if="unit" 
            class="input-group-append"
        >
            <span class="input-group-text">{{ unit }}</span>
        </div>
        <div 
            v-if="isComputed"
            class="input-group-append"
            >
            <span class="input-group-text">x<span class="price">{{ +unitPrice }}</span> {{ dic.valute }}</span>
        </div>   
        <div 
            v-if="isComputed"
            class="input-group-append"
            >
            <span class="input-group-text">=<span class="price">{{ total | separate }}</span> {{ dic.valute }}</span>
        </div>         
    </div>      
    <div v-if="hasErrorsForShow()" class="help-block">{{ currentError.message }}</div>        
</div>
</template>
<script>
    import { unitMixin } from './Mixins/unitMixin'
    import { labelMixin } from './Mixins/labelMixin'
    import { computedMixin } from './Mixins/computedMixin'
    import { eventBus } from '../../eventBus'
    import { numberFormatMixin } from './Mixins/numberFormatMixin'
    export default {
        props: [
            'dic','lang'
        ],    
       data() {
           return {
            id: 'id' + this.params.id,
            val: this.params.value,     
            currentError: null,
            showErrors : false,
            valid : true,            
          //  required : false,
            errors : {
                required: {
                    message: "Поле обязательно для заполнения"
                },
                notNumber: {
                    message: "Заполняемое поле должно быть числом"
                }
            }
           }
       },
       computed: {          
           total() {
               let total = 0;
               if (!this.isComputed) {
                   return 0;
               }
               let val = +this.val;
               total = val * (+this.unitPrice);
               if (isNaN(total)) {
                   return 0;
               }
               return total;               

           }
       },
       mixins: [
           unitMixin,
           computedMixin,
           numberFormatMixin,
           labelMixin
       ],
       created() {
           this.$emit('changeField',this.getData());
           eventBus.$on('showErrors',() => this.showErrors = true);
           eventBus.$on('validate',() => {
               this.validate();
               this.$emit('changeField',this.getData());
           });
       },
       methods: {
           isNumber(val) {            
                return /^\d+$/.test(val);
            },
           validate() {
               this.valid = true; // default
               this.currentError = null;
               if(this.val == '') {
                   if (this.required) {
                       this.currentError = this.errors.required;
                       this.valid = false;
                       return;
                   }
                   return;
               }
               if (!this.isNumber(this.val)) {
                   this.currentError = this.errors.notNumber;
                   this.valid = false;
                   return;
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
               let data = {
                   id: this.id,
                   data:  {
                       value: this.val,                       
                    },
                   valid: this.valid
               };
               this.validate();
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