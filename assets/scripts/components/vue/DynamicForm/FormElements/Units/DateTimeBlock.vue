<template>
<div class="form-group align-right">
<div class="flex__wrapper" :class="{'required' : required }">
    <label  :for="id">{{ titleLabel }}</label>
    <date-picker 
        v-model="val" 
        :inputAttr="dateAttributes"
        :inputClass="'form-control'"
        type="datetime" 
        value-type="format"
        format="DD.MM.YYYY hh:mm"></date-picker>           
</div>
    <div v-if="hasErrorsForShow()" class="help-block">{{ errors.required.message }}</div>  
    <div v-if="!hasErrorsForShow()" class="desc-block">{{ descriptionLabel }}</div>  
</div>
</template>
<script> 
    import { unitMixin } from './Mixins/unitMixin'
    import { labelMixin } from './Mixins/labelMixin'  
    import { eventBus } from '../../eventBus'
    import DatePicker from  'vue2-datepicker';
    import 'vue2-datepicker/locale/ru';
    import 'vue2-datepicker/index.css'; 
    
    export default {        
        props: [
            'lang'
        ],
        components: { DatePicker },
       data() {           
           return {
            id: 'id' + this.params.id,
            val: this.params.value ? this.params.value : '',
            showErrors : false,
            valid: true,  
            errors : {
                required: {
                    message: "Поле обязательно для заполнения"
                }
            }
           }
       },  
       computed: {
        dateAttributes() {
            return {
                id: this.id                            
            };
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
<style>
</style>