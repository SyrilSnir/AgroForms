<template>
   <div class="form-group align-right">      
      <div v-for="(item, index) in formElements" class="container-fluid">
       <div class="card card-default">
         <div class="card-header">
           <h3 class="card-title">{{ titleLabel }} #{{ index+1 }}</h3>
           
           <div v-if="blocksCount > 1" class="card-tools">
               <button @click="removeItem(index)" type="button" class="btn btn-tool">
                   <i class="fas fa-times"></i>
               </button>
           </div>
       </div>
       <label>Имя:</label>
       <input 
           type="text" 
           class="form-control"
           v-model="item.name"
           @change="onChange($event)"           
           placeholder="">
      <label>Отчество:</label>
       <input 
           type="text" 
           class="form-control"
           v-model="item.middleName" 
           @change="onChange($event)"                     
           placeholder="">                        
           <label>Фамилия:</label>
       <input 
           type="text" 
           class="form-control"
           v-model="item.surName" 
           @change="onChange($event)"       
           placeholder="">                        
           <label>Компания:</label>
           <input 
           type="text" 
           class="form-control"
           v-model="item.company"
           @change="onChange($event)"           
           placeholder="">                        
       </div> 
   </div> 
       <button @click="addFormBlock" class="btn btn-primary">Добавить еще:</button>     
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
                    name: '',
                    middleName: '',
                    surName: '',
                    company: '',
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
   .form-group {
      margin: 2rem 0;
   }
 </style>