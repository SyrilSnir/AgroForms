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
                <button type="button" @click="saveDraft" class="btn btn-primary">{{ dict.buttons.draft }}</button>
                <button type="button" @click="formSubmit" class="btn btn-success">{{ dict.buttons.send }}</button>
                <button type="button" @click="cancel" class="btn btn-secondary">{{ dict.buttons.cancel }}</button>
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

    data() {
        return {
            title: '',
            elements: [],
            draft: false,
            fields: {},
            formData : new FormData(), 
            formType : null,
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
    axios.get('/api/dynamic-form/get-form')
        .then((response) => {
            this.title = response.data.title; 
            this.elements = response.data.elements;  
            this.isComputed = response.data.computed ; 
            this.userId = response.data.userId;
            this.formType = response.data.formType,       
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
              total : total
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
                'DynamicForm[formType]', this.formType
            );                            
            axios.post( '/api/dynamic-form/send-form',
                this.formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
                ).then(function(){
                   location.href = '/manage/member/requests';
                })
                .catch(function(){
                    location.href = '/manage/member/requests';
                    console.log('FAILURE!!');
                });                    
      },
      cancel() {
        location.href = '/manage/member/requests';          
      }
  }
}
</script>
<style scoped>
</style>