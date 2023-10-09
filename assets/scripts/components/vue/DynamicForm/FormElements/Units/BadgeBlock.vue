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
       <label>{{ getName('Имя', 'Name') }}:</label>
       <input 
           type="text" 
           class="form-control"
           v-model="item.name"
           @change="onChange($event)"           
           placeholder="">
      <label>{{ getName('Отчество', 'Middle Name') }}:</label>
       <input 
           type="text" 
           class="form-control"
           v-model="item.middleName" 
           @change="onChange($event)"                     
           placeholder="">                        
           <label>{{ getName('Фамилия', 'Surname') }}:</label>
       <input 
           type="text" 
           class="form-control"
           v-model="item.surName" 
           @change="onChange($event)"       
           placeholder="">                        
           <label>{{ getName('Компания', 'Company')}}:</label>
           <input 
           type="text" 
           class="form-control"
           v-model="item.company"
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
import { labelMixin } from './Mixins/labelMixin';
import { computedMixin } from './Mixins/computedMixin';
import { formList } from './Mixins/formListMixin';
import { textTranslateMixin } from './Mixins/textTranslateMixin';
import { numberFormatMixin } from './Mixins/numberFormatMixin';

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
   .form-group {
      margin: 2rem 0;
   }
   .card label {
        font-weight: 300!important;
    }
    .card-title {
        font-weight: 700;
    }   
 </style>