<template>
    <div class="form-group align-right">
        <div v-for="(item,index) in formElements" class="container-fluid">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">{{ titleLabel }} #{{ index+1 }}</h3>
            
            <div  v-if="blocksCount > 1" class="card-tools">
                <button @click="removeItem(index)" type="button" class="btn btn-tool">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <label>{{ getName('Сайт','Site') }}:</label>
        <input 
            type="text" 
            class="form-control"
            v-model="item.site"
           @change="onChange($event)"               
            placeholder="">
            <label>E-mail:</label>
        <input 

            type="text" 
            class="form-control"
            v-model="item.email"
           @change="onChange($event)"               
            placeholder="">
            <label>{{getName('Телефон', 'Phone')}}:</label>
        <input 
            type="text" 
            class="form-control"
            v-model="item.phone"
           @change="onChange($event)"               
            placeholder="">                        
        </div>       
    </div> 
        <div v-if="isComputed" class="field__price"><span class="price">{{ total }}</span> {{ dic.valute }}</div>
        <button @click="addFormBlock" class="btn btn-primary">{{ getName('Добавить еще', 'Add more')  }}</button>     
    </div>  
 </template>
 <script>
 import { labelMixin } from './Mixins/labelMixin';
import { computedMixin } from './Mixins/computedMixin';
import { formList } from './Mixins/formListMixin';
import { textTranslateMixin } from './Mixins/textTranslateMixin';
import { numberFormatMixin } from './Mixins/numberFormatMixin';

 export default {
    data() {
        return {
            defaultElement : {
                    site: '',
                    email: '',
                    phone: '',
                },
        }
     },
     props: ['params','dic','lang'],
     mixins: [
      labelMixin,
      computedMixin,
      formList,
      textTranslateMixin,
        numberFormatMixin  
     ],        
 }
 </script>
 <style scope>
 </style>