<template>
    <div class="form-group align-right">
        <div class="flex__wrapper" :class="{'required' : required }">
            <p>{{ titleLabel }}</p>
            <div class="date-list__wrapper">
                <div v-for="elem,index in elements" class="date-element">
                    <date-picker 
                        v-model="elem.date" 
                        :inputAttr="dateAttributes(index)"
                        :inputClass="'form-control'"
                        type="date" 
                        value-type="format"
                        format="DD.MM.YYYY">
                    </date-picker>
                    <div class="buttons__block">

                        <span v-if="index == 0" @click="add()" class="btn" title="Добавить дату">
                            <i class="fas fa-plus"></i>
                        </span>                
                        <span v-else @click="remove(index)" class="btn" title="Удалить дату">
                            <i class="fas fa-minus"></i>
                        </span>
                    </div>
                </div>
            </div>  
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

                elements: [],
                showErrors : false,
                defaultDate: '01.01.2022',
                
                valid: true,
                errors : {
                    required: {
                        message: "Поле обязательно для заполнения"
                    }
                }
               }
           },  
           computed: {            
                val() {                  
                    return this.elements.map((el) => el.date ).join(',');
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
                if (!this.params.value) {
                    this.params.value = this.defaultDate
                }                    
                this.elements = this.params.value.split(',').map((el) => {return { date: el }});
           },
           methods: {
                add() {
                 /*   let values = this.val.split(',');
                    values.push(this.defaultDate);
                    this.val = values.join(',');*/
                    this.elements.push({date: this.defaultDate});
                },
                remove(index) {

                    this.elements.splice(index,1);;
                },
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
               dateAttributes(index) {
                return {
                    id: this.id + '_' + index
                };
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
    <style scoped>
        .date-list__wrapper {
            flex-grow: 1;
            text-align: right;            
        }
        .date-element {
            margin-bottom: 1rem;
        }
        .buttons__block {
            display: inline-block;
            width: 6rem;
        }
    </style>