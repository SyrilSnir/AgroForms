<template>
    <div class="card card-primary">
        <div class="card-header">
            {{title}}
        </div>
        <div class="card-body">
            <div class="app-info__wrapper">
                <div class="app-info">
                    <p>{{ dict.contractInfo.standNumber }}:<span>{{ this.standNumber }}</span></p>
                    <p>{{ dict.contractInfo.hall }}:<span>{{ this.hall }}</span></p>
                    <p>{{ dict.contractInfo.standSquare }}:<span>{{ this.standSquare }}</span></p>
                </div>
            </div>
            <template v-for="elem in elements">
                <el :unitData="elem" v-if="!elem.isGroup" @modification="fieldsModificate" :lang="language" :dic="dict" :exhibitionId="exhibitionId"></el>
                <group 
                    :fields="elem.fields"
                    :title="getFieldName(elem.name,elem.name_eng)"
                    :lang="language"
                    :exhibitionId="exhibitionId"
                    :dic="dict"
                    v-if="elem.isGroup"
                    @modification="fieldsModificate"
                >
                </group>
            </template>
            <div v-show="isFileUpload" class="form-group clr">
                <p class="d-flex flex-column">
                    <span>{{ dict.fileAttach.attachFile }}</span>
                </p>             
                <div class="input-group">
                    <div class="custom-file">
                        <input @change="fileLoad" ref="userFile" type="file" class="custom-file-input" id="userFile">
                        <label class="custom-file-label" :data-browse="dict.fileAttach.browse" for="userFile">Select file</label>
                    </div>
                </div>
                <div v-if="hasFile" class="file__added">
                    <i class="fa fa-file" aria-hidden="true"></i>
                    <a :href="attachedFile">{{ attachedFile }}</a></div>
                    <div v-if="showLimitSizeOfFileMsg" class="error-message">{{ dict.fileAttach.limitSizeMessage }}</div>
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
import * as constants from './utils/constants'

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
            attachedFile: '',
            elements: [],
            fileFields: [],
            files: {},
            standNumber: null,
            standSquare: null,
            hall: null,
            draft: false,
            fields: {},
            formData : new FormData(), 
            formId : null,
            exhibitionId : null,
            isComputed: false,
            userId : null,
            companyId: null,            
            basePrice: 0,
            isFileUpload: false,
            totalPrice: 0,
            addedFile: false,
            showLimitSizeOfFileMsg: false,
            language: languages.russian,               
            dict: {
                fileAttach: {},
                buttons: {},
                contractInfo: {}
            }
        }
    },
  created: function() {
    axios.get('/api/application/get-form?contractId=' + this.contractId)
        .then((response) => {
            this.title = response.data.title; 
            this.elements = response.data.elements;  
            this.isComputed = response.data.computed ; 
            this.userId = response.data.userId; 
            this.standNumber = response.data.standNumber;
            this.standSquare = response.data.standSquare;
            this.hall = response.data.hall;
            this.attachedFile = response.data.attachedFile;      
            this.companyId = response.data.companyId;
            this.basePrice = response.data.basePrice;
            this.totalPrice = this.basePrice;
            this.formId = response.data.formId;
            this.exhibitionId = response.data.exhibitionId;
            this.isFileUpload = response.data.isFileUpload;
            this.language = response.data.language;
            this.dict = response.data.dict;                    
        })
  },
  computed: {
    hasFile() {
        return !(this.attachedFile == '');
    }
  },
  methods: {
        getFieldName(name,nameEng) {
            if (this.language == languages.russian || !nameEng) {
                return name;
            }
            return nameEng;
        },
        fileLoad: function(event) {
            this.showLimitSizeOfFileMsg = false;
            const element = event.target;
            let fsize = element.files[0].size;
            if (fsize > constants.MAX_FILE_SIZE) {
                this.showLimitSizeOfFileMsg = true;
            } else {
                this.formData.append('DynamicForm[attached][formFile]', this.$refs.userFile.files[0]);
                this.addedFile = '';
                this.showLimitSizeOfFileMsg = false;
            }
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
        if (field.hasOwnProperty(constants.ATTACHMENT_ATTRIBUTE)) {
            if (field.file) {                
                this.files[field.id] = field.file;
            } else {
                if (this.files.hasOwnProperty(field.id)) {
                    delete this.files[field.id];
                }
            } 
            console.log('Change field', field,this.files);
           // return;
        }
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
            this.formData.append(
                'DynamicForm[companyId]', this.companyId
            );             
            console.log(this.files);
            for (const elementId in this.files) {
                this.formData.append(
                    `AttachedFilesForm[files][${elementId}]`, this.files[elementId]
                );
                this.fileFields.push(elementId);
                console.log(this.files[elementId]); 
            }
            this.formData.append(
                'AttachedFilesForm[fileFields]', this.fileFields
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
              //      location.href = '/panel/member/requests';
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
    .error-message {
        color: red;
    }
</style>