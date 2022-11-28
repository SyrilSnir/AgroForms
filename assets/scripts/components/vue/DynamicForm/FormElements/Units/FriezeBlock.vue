<template>
<div class="form-group">
    <label :for="id">{{ titleLabel }}</label>
        <div class="col-12">    
            <div class="input-group">
                <input 
                    :id="id"
                    type="text" 
                    class="form-control"
                    v-model="val"
                    @change="onChange($event)"
                    placeholder="Enter ...">  
                        
            </div>
            <div  class="col-12" v-if="isPaid">
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
    import { labelMixin } from './Mixins/labelMixin'  
    export default {        
        props: [
            'lang',
            'params',
            'dic'
        ],

       data() {           
           return {
            id: 'id' + this.params.id,
            val: this.params.value,
            currentVal: this.params.value,            
            valid: true,
           }
       },      
       mixins: [
        //  unitMixin,
           labelMixin
       ],
       computed: {
        symsLength() {
            return this.val.trim().length;
        },
        frizeDigitPrice() {
            return parseInt(this.params.parameters.digitPrice);
        },
        frizeFreeDigits() {
            return parseInt(this.params.parameters.freeDigitCount);
        },
        isPaid() {
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
           onChange(event) {
               this.$emit('changeField',this.getData());
           },
           getData() {
               return {
                   id: this.id,
                   computed: true,
                   total: this.total,
                   data:  {
                       value: this.val,  
                    },
                   valid: true
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