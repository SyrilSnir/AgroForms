<template>
<div class="form-group">
    <div class="custom-control custom-checkbox">
        <input @change="change" class="custom-control-input" type="checkbox" :id="id" v-model="checked">
        <label :for="id" class="custom-control-label">{{ titleLabel }}</label>
        <div style="margin-top: 10px;" class="col-12" v-if="hasComment && checked">    
            <p>{{ getName('Комментарий','Comment')}}</p>
            <div class="input-group"> 
                <textarea 
                    name="comment__lield" 
                    cols="30" 
                    :rows="rows"
                    type="text" 
                    class="form-control"
                    v-model="comment"
                    @change="onChange($event)"                    
                    placeholder="Enter ..."  
                >                  
                </textarea>
                        
            </div>
        </div>
        <table v-if="checked && isComputed" class="table"><tbody>
      <tr style="font-weight: 600">
          <td>{{ getName('Итого','Total') }}:</td>
          <td style="text-align: right"><span class="price">{{ total | separate }}</span> {{ dic.valute }}</td>
      </tr></tbody></table>       

    </div>
</div>
</template>
<script>
    import { unitMixin } from './Mixins/unitMixin'
    import { labelMixin } from './Mixins/labelMixin'
    import { computedMixin } from './Mixins/computedMixin'
    import { textTranslateMixin } from './Mixins/textTranslateMixin';
    import { numberFormatMixin } from './Mixins/numberFormatMixin';
    export default {
        props: [
            'lang',
            'dic'
        ],         
       data() {
           return {
                id: 'id' + this.params.id,                 
                checked: this.params.checked,
                comment: '',
                valid: true,              
           }
       },        
       mixins: [
           unitMixin,
           computedMixin,
           labelMixin,
           textTranslateMixin,
           numberFormatMixin
       ],
       created() {
           this.$emit('changeField',this.getData());
           this.comment = this.params.comment;
       }, 
       computed: { 
            rows() {
                return Math.round(this.comment.length / 100) + 1;
            },
            hasComment() {
                return this.parameters.hasCommentField == 1;
            },       
           total() {
               if (!this.isComputed || !this.checked) {
                   return 0;
               }
               return +this.unitPrice;
           }
       },       
       methods: {
            onChange(event) {
               this.$emit('changeField',this.getData());
           },        
           change() {
               this.params.value = this.checked;
                this.$emit('changeField',this.getData());               
           },
           getData() {
               let data = {
                   id: this.id,
                   data:  {
                       value: this.unitPrice, 
                       checked: this.checked,
                       hasCommentField: this.hasComment,
                       comment: this.comment,
                    },
                   valid: this.valid,
                   checkbox: true,                  
               };
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