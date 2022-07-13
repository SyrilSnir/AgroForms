<template>
<div class="form-group">
    <label :for="id">{{ titleLabel }}</label>
        <div class="col-sm-10">    
            <div class="input-group mb-3">
                <input 
                    :id="id"
                    type="text" 
                    class="form-control"
                    v-model="val"
                    :value="val"
                    @change="onChange($event)"
                    placeholder="Enter ...">  
                    <div class="input-group-append">
                        <span class="input-group-text">{{paiedFrizeSigns}} {{ dic.symbol }}</span>
                    </div>
                    <div class="input-group-append">
                        <span class="input-group-text">x {{frizeDigitPrice}} {{ dic.valute }}</span>
                    </div>                         
            </div>
        </div>
    </div>
</template>
<script> 
    import { labelMixin } from './Mixins/labelMixin'  
    import { eventBus } from '../../eventBus'
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
            valid: true,
           }
       },      
       mixins: [
        //  unitMixin,
           labelMixin
       ],
       computed: {
        frizeDigitPrice() {
            return parseInt(this.params.parameters.digitPrice);
        },
        frizeFreeDigits() {
            return parseInt(this.params.parameters.freeDigitCount);
        },
        paiedFrizeSigns: function() {
            if (this.val) {
                let symsLength = this.val.replace(/[\s]/g,"").length;
                return (symsLength > this.frizeFreeDigits) ? symsLength - this.frizeFreeDigits : 0;
            }
            return 0;
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
<style></style>