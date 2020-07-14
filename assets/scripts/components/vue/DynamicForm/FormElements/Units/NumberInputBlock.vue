<template>
<div class="form-group">
    <label :for="id">{{ params.name }}</label>
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
            <span class="input-group-text">x<span class="price">{{ +unitPrice }}</span> РУБ</span>
        </div>   
        <div 
            v-if="isComputed"
            class="input-group-append"
            >
            <span class="input-group-text">=<span class="price">{{ total }}</span> РУБ</span>
        </div>         
    </div>      
    <div v-if="hasErrorsForShow()" class="help-block">{{ currentError.message }}</div>        
</div>
</template>
<script>
    import { unitMixin } from './Mixins/unitMixin';
    import { computedMixin } from './Mixins/computedMixin';
    import { eventBus } from '../../eventBus';
    export default {
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
               if (!this.isComputed) {
                   return 0;
               }
               let val = +this.val;
               return val * (+this.unitPrice);
           }
       },
       mixins: [
           unitMixin,
           computedMixin
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