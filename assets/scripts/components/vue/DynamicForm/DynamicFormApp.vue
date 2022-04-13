<template>
    <div class="card card-primary">
        <div class="card-header">
            {{title}}
        </div>
        <div class="card-body">
            <template v-for="elem in elements">
                <el :unitData="elem" v-if="!elem.isGroup" @modification="fieldsModificate" :lang="language" :dic="dict"></el>
                <group 
                    :fields="elem.fields"
                    :title="getFieldName(elem.name,elem.name_eng)"
                    :lang="language"
                    :dic="dict"
                    v-if="elem.isGroup"
                    @modification="fieldsModificate"
                >
                </group>
            </template>
            <div v-show="hasFile" class="form-group clr">
                <p class="d-flex flex-column">
                    <span>{{ dict.fileAttach.attachFile }}</span>
                </p>             
                <div class="input-group">
                    <div class="custom-file">
                        <input @change="fileLoad" ref="userFile" type="file" class="custom-file-input" id="userFile">
                        <label class="custom-file-label" :data-browse="dict.fileAttach.browse" for="userFile">Select file</label>
                    </div>
                </div>
                <div v-if="addedFile" class="file__added">
                    <i class="fa fa-file" aria-hidden="true"></i>
                    {{ addedFile }}</div>
            </div>

            <computed 
                v-if="isComputed" 
                :total="totalPrice"
                :dic="dict"
            ></computed>
            <div class="card-footer">
                <button v-if="!isReadOnly" type="button" @click="saveDraft" class="btn btn-primary">{{ dict.buttons.draft }}</button>
                <button v-if="!isReadOnly" type="button" @click="formSubmit" class="btn btn-success">{{ dict.buttons.send }}</button>
                <button v-if="!isReadOnly" type="button" @click="cancel" class="btn btn-secondary">{{ dict.buttons.cancel }}</button>
                <button v-if="isReadOnly" type="button" @click="close" class="btn btn-secondary">{{ dict.buttons.close }}</button>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios"
import Element from "./FormElements/Element"
import Group from './FormElements/Group'
import Computed from './FormElements/ComputedEl'
import { eventBus } from './eventBus'
import { languages } from '../lang'
export default {    
    components: {
        el: Element,
        group: Group,
        computed: Computed
    },
    props: [
        'isReadOnly','contractId'
    ],
    data() {
        return {
            title: '',
            elements: [],
            draft: false,
            fields: {},
            formData : new FormData(), 
            formId : null,
            isComputed: false,
            userId : null,            
            basePrice: 0,
            totalPrice: 0,
            hasFile: false,
            addedFile: false,
            language: languages.russian,               
            dict: {
                fileAttach: {},
                buttons: {}
            }
        }
    },
   beforeCreate: function() {
    axios.get('/api/application/get-form')
        .then((response) => {
            this.title = response.data.title; 
            this.elements = response.data.elements;  
            this.isComputed = response.data.computed ; 
            this.userId = response.data.userId;       
            this.basePrice = response.data.basePrice;
            this.totalPrice = this.basePrice;
            this.formId = response.data.formId;
            this.hasFile = response.data.hasFile;
            this.language = response.data.language;
            this.dict = response.data.dict;
            if (this.hasFile) {
                this.addedFile = response.data.fileName;
            }

        })
  },
  methods: {
        getFieldName(name,nameEng) {
            if (this.language == languages.russian || !nameEng) {
                return name;
            }
            return nameEng;
        },
        fileLoad: function() {
            console.log('Файл загружен');
            this.formData.append('DynamicForm[loadedFile]', this.$refs.userFile.files[0]);
            this.addedFile = '';
        },      
        saveDraft: function() {
            this.draft = true;
            this.formSubmit();
        },      
        isFormValid() {
            let valid = true;
            for (let field in this.fields) {
                if (!this.fields[field].valid) {
                    valid = false
                }
            }
            return valid;
        },      
      fieldsModificate(field) {
        let computed = false;
        let total = 0;
        if(field.hasOwnProperty('computed')) {
            computed = true;
            total = field.total;
        }        
        this.fields[field.id] = {
              data : field.data,
              valid : field.valid,
              computed : computed,
              total : total,
              checkbox: field.hasOwnProperty('checkbox') ? true : false,
              equip: field.hasOwnProperty('equip') ? true : false
              };
          if (this.isComputed) {
              this.calculatePrice(this.fields);
          }
      },
      calculatePrice(fields) {
          let price = this.basePrice;
          for (let field in this.fields) {
              let el = fields[field];
              if (el.computed) {
                  price += el.total
              }
          }
          console.log(fields);
          console.log('price= ' + price);
          this.totalPrice = price;
      },
      formSubmit() {
            eventBus.validate();
            if (!this.isFormValid()) {
                eventBus.showErrors();
                console.log('Форма не валидна');
                return;
            }
            console.log('Форма отправлена');
            this.formData.append(
                'DynamicForm[fields]', JSON.stringify(this.fields)
            );
            this.formData.append(
                'DynamicForm[userId]', + this.userId
            );
            this.formData.append(
                'DynamicForm[formId]', + this.formId
            );                   
            this.formData.append(
                'DynamicForm[draft]', + this.draft
            );             
            this.formData.append(
                'DynamicForm[total]', this.totalPrice
            );
            this.formData.append(
                'DynamicForm[basePrice]', this.basePrice
            );   
            this.formData.append(
                'DynamicForm[contractId]', this.contractId
            );                            
            axios.post( '/api/application/send-form',
                this.formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
                ).then(function(response){
                   location.href = '/panel/member/'+ response.data.exhibitionId +'/requests/' + response.data.contractId;
                })
                .catch(function(){
                    location.href = '/panel/member/requests';
                    console.log('FAILURE!!');
                });                    
      },
      cancel() {
            window.history.back();         
      },
      close() {
            window.location.href = '/panel/forms';
     },
  }
}
</script>
<style scoped>
</style>