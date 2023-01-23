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
        <label>Сайт:</label>
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
            <label>Телефон:</label>
        <input 
            type="text" 
            class="form-control"
            v-model="item.phone"
           @change="onChange($event)"               
            placeholder="">                        
        </div>       
    </div> 
        <button @click="addFormBlock" class="btn btn-primary">Добавить еще</button>     
    </div>  
 </template>
 <script>
 import { labelMixin } from './Mixins/labelMixin';
import { computedMixin } from './Mixins/computedMixin';
import { formList } from './Mixins/formListMixin';

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
     mixins: [
      labelMixin,
      computedMixin,
      formList
     ],        
 }
 </script>
 <style scope>
 </style>