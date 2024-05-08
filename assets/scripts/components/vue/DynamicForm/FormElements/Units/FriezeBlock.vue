<template>
<div class="form-group">
    <label :for="id">{{ titleLabel }}</label>
        <div class="col-12">    
            <div class="input-group">
                <input 
                    v-if="friezeFieldType != 1"
                    :id="id"
                    type="text" 
                    class="form-control"
                    v-model="val" 
                    @input="onChange($event)"
                    placeholder="Enter ...">  
                <textarea 
                    v-else
                    name="frieze__area" 
                    cols="30" 
                    :rows="rows"
                    :id="id"
                    type="text" 
                    class="form-control"                  
                    v-model="val"
                    @input="onChange($event)"
                    placeholder="Enter ..."  
                >                  
                </textarea>
            </div>
            <div v-if="hasMaxDigits" class="help-block info">{{ symsLength }} {{ getName('из','of') }} {{ maxDigits }} {{ getName('знаков','signs') }}</div>          
            <div class="col-12" v-if="isPaid">
                <div class="input-group additiomal">                
                <span>{{dic.addSymbols}}: </span>
                    <div class="input-group-append">
                        <span class="input-group-text">{{paiedFrizeSigns}} {{ dic.symbol }}</span>
                    </div>
                
                    <div class="input-group-append">
                        <span class="input-group-text">x {{frizeDigitPrice}} {{ dic.valute }}</span>
                    </div>                 
                    <div class="input-group-append">
                        <span class="input-group-text">= {{frizePrice}} {{ dic.valute }}</span>
                    </div>                      
                </div>
            </div>
        </div>
    </div>
</template>
<script> 
    import { labelMixin } from './Mixins/labelMixin';
    import { textTranslateMixin } from './Mixins/textTranslateMixin';
    export default {        
        props: [
            'lang',
            'params',
            'dic'
        ],

       data() {           
           return {
            id: 'id' + this.params.id,
            val: this.params.value ? this.params.value : '',
            currentVal: this.params.value ? this.params.value : '',  
            showErrors : false,            
            valid: true,
        }
    },      
    mixins: [
        textTranslateMixin,
        labelMixin
    ],
    computed: {
        errors()  {
            return {
                overLimit: {
                    message: "Количество знаков не должно превышать " + this.maxDigits
                }
            }
        },   
        hasMaxDigits() {
            return this.maxDigits > 0;
        },                
        symsLength() {
            return this.val.trim().length;
        },
        rows() {
                return Math.round(this.val.length / 100) + 1;
            },        
        frizeDigitPrice() {
            return parseInt(this.params.parameters.digitPrice);
        },
        maxDigits() {
            return parseInt(this.params.parameters.maxDigitCount);
        },        
        friezeFieldType() {
            return parseInt(this.params.parameters.friezeFieldType);
        },        
        frizeFreeDigits() {
            return parseInt(this.params.parameters.freeDigitCount);
        },
        isPaid() {
            if (!(this.frizeFreeDigits > 0)) return false;
            if (!this.val) return false;
            return (this.symsLength > this.frizeFreeDigits);
        },
        paiedFrizeSigns: function() {
            return (this.isPaid) ? this.symsLength - this.frizeFreeDigits : 0;
        },
        frizePrice: function() {
            return this.frizeDigitPrice * this.paiedFrizeSigns;
        }, 
        total() {
            return this.frizePrice;
        }
       },
       created() {
           this.$emit('changeField',this.getData());
       },
       methods: {  
            validate() {
                this.valid = true; // default
                if (this.maxDigits > 0) {
                    if (this.symsLength > this.maxDigits) {
                        this.valid = false;
                        this.showErrors = true;
                        this.val = this.val.substring(0,this.maxDigits);
                    } else {
                        this.valid = true;
                        this.showErrors = false;
                    }
                }
            },                  
           onChange(event) {
               this.validate();
               this.$emit('changeField',this.getData());
           },
           getData() {
               this.validate();
               return {
                   id: this.id,
                   computed: true,
                   total: this.total,
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
.additiomal {
    display: flex;
    justify-content: right;
    align-items: center;
    margin-top: 5px;
}
.additiomal span {
    padding-right: 1rem;
}
</style>