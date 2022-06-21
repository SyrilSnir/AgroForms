<template>
<div class="form-group check__number">
        <div class="custom-control custom-checkbox">
        <input @change="change" class="custom-control-input" type="checkbox" :id="id" v-model="checked">
        <label :for="id" class="custom-control-label">{{ titleLabel }}</label>
    </div>
    <div v-if="checked" class="input-block">
<div class="input-group">

    <input 
        :id="id"
        type="text" 
        class="form-control"
        :class="{'is-invalid' : hasErrorsForShow() }" 
        v-model="val"
        @change="onChange($event)"
        placeholder="Enter ...">
        <div v-if="unit" class="input-group-append">
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
            checked: this.params.checked,   
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
       mixins: [
           unitMixin, computedMixin, labelMixin, numberFormatMixin
       ],
       computed: {
           total() {
               if (!this.isComputed || !this.checked) {
                   return 0;
               }
               let val = +this.val * (+this.unitPrice);
               if (isNaN(val)) {
                   return 0;
               }
               return val;
           }
       },       
       created() {
           this.$emit('changeField',this.getData());
           eventBus.$on('showErrors',() => this.showErrors = true);
           eventBus.$on('validate',() => {
               this.validate();
               this.$emit('changeField',this.getData());
           });
       },
       methods: {
           change() {
                this.$emit('changeField',this.getData());               
           },           
            isNumber(val) {            
                return /^\d+$/.test(val);
            },
           validate() {
               this.valid = true; // default
               if (!this.checked) {
                   return;
               }
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
               this.validate();
               let data = {
                            id: this.id,
                            data:  {
                                value: this.val,
                                checked: this.checked
                            },
                            valid: this.valid
                        };
               if (this.isComputed && this.checked) {
                   data.computed = true;
                   data.total = this.total;
               }
               return data;
           }
       } 
    }
</script>
<style scoped>
    .check__number {
       display: flex; 
       flex-wrap: wrap;
       align-items: center;
       justify-content: left;
    }
    .check__number .custom-checkbox {
        margin-right: 2rem;
    }
    .check__number .input-block {
        flex-grow: 1;
    }
</style>