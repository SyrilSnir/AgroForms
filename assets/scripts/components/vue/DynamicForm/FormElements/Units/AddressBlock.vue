<template>
    <div class="form-group align-right agro">
       
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
            
            <label :for="'select-country-' + index">{{ getName('Страна', 'Country') }}:</label>        
            <Select2 
            v-model="item.country" 
            :id="'select-country-' + index"
            :options="myOptions" 
            @change="myChangeEvent($event)" 
            @select="mySelectEvent($event)" 
            :settings="{ placeholder: 'Select', theme: 'bootstrap',}"
            />
        
            <label>{{ getName('Область','Region') }}:</label>
        <input 

            type="text" 
            class="form-control"
            v-model="item.area"
           @change="onChange($event)"               
            placeholder="">
            <label>{{ getName('Город', 'City') }}:</label>
        <input 
            type="text" 
            class="form-control"
            v-model="item.city"
           @change="onChange($event)"               
            placeholder="">                        
            <label>{{ getName('Индекс', 'Zip code') }}:</label>
        <input 
            type="text" 
            class="form-control"
            v-model="item.index"
           @change="onChange($event)"               
            placeholder="">                        
            <label>{{ getName('Адрес', 'Address') }}:</label>
        <input 
            type="text" 
            class="form-control"
            v-model="item.address"
           @change="onChange($event)"   
            placeholder="">                        
        </div> 
    </div> 
    <table v-if="isComputed" class="table"><tbody>
      <tr style="font-weight: 600">
          <td>{{ getName('Итого','Total') }}:</td>
          <td style="text-align: right"><span class="price">{{ total | separate }}</span> {{ dic.valute }}</td>
      </tr></tbody></table> 
        <button @click="addFormBlock" class="btn btn-primary">{{ getName('Добавить еще', 'Add more')  }}</button>     
    </div> 
 </template>
 <script>
import { computedMixin } from './Mixins/computedMixin';
import { formList } from './Mixins/formListMixin';
import { labelMixin } from './Mixins/labelMixin';
import { textTranslateMixin } from './Mixins/textTranslateMixin';
import { numberFormatMixin } from './Mixins/numberFormatMixin';
import Select2 from 'v-select2-component';
import axios from "axios";

 export default {
     components: {
         Select2
     },
     beforeCreate: function() {
        axios.get('/api/geography/get-countries')
            .then((response) => {
                this.myOptions = response.data;
            });
    },     
     data() {
        return {
            myValue: '',
            myOptions: [],           
            defaultElement : {
                    country: null,
                    area: '',
                    city: '',
                    index: '',
                    address: '',
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
     methods: {
        myChangeEvent(val){
            console.log(val);
        },
        mySelectEvent({id, text}){
            console.log({id, text})
        }        
     }   
 }
 </script>
 <style scope>
    .card:last-child {
        margin-bottom: 0;
    }
    .card label {
        font-weight: 300!important;
    }
    .card-title {
        font-weight: 700;
    }
    .select2-container .select2-selection--single .select2-selection__rendered {
        text-align: right;
        font-weight: 500;
    }      
 </style>