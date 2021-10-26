<template>
<div class="card card-primary">
    <div class="card-header">
        {{title}}
    </div>
    <stand-list
        :local-selected-stand="defaultSelectedStand"
        :standElements="stands"
        :bus="bus"
        :dict="dict"
        :standSquare="defaultSquare"
        @changeSquare="square = $event.square; standPrice = $event.fullPrice"
        @changeSelectedStand="standId = $event"
    >
    </stand-list>
    <div class="plan">
        <h5 class="mt-4 mb-2">{{ dict.standPlan.header }}</h5>
        <p class="d-flex flex-column">
            <span>{{ dict.standPlan.downloadInfo }}</span>
        </p>
        <a href="\upload\stand_blank_ru.pdf" class="btn btn-primary float-left" style="display:block;margin-right: 5px;">
            <i class="fas fa-download"></i>{{ dict.standPlan.download }}
        </a>   
        <div class="form-group clr">
            <p class="d-flex flex-column">
                <span>{{ dict.standPlan.attachInfo }}</span>
            </p>                         
            <div class="input-group">
                <div class="custom-file">
                    <input @change="fileLoad" ref="userFile" type="file" class="custom-file-input" id="userFile">
                    <label class="custom-file-label" :data-browse="dict.fileAttach.browse" for="userFile">{{ dict.fileAttach.selectFile }}</label>
                </div>
            </div>
                <div v-if="addedFile" class="file__added">
                    <i class="fa fa-file" aria-hidden="true"></i>
                    {{ addedFile }}
                </div>            
        </div>      
    </div>  
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">{{ dict.standSize }}</h3>
        </div>
        <div class="card-body">
            <div class="form-group row">                 
                    <label for="inputlength" class="col-sm-2 col-form-label">{{ dict.standInfo.length }}:</label>
                    <div class="col-sm-10">    
                        <div class="input-group mb-3">         
                        <input v-model="length" type="text" class="form-control" id="inputlength" name="inputlength">
                        <div class="input-group-append">
                            <span class="input-group-text">{{ dict.standInfo.unit }}</span>
                        </div>                         
                    </div>
                </div>
            </div>
            <div class="form-group row">  
                <label for="inputWidth" class="col-sm-2 col-form-label">{{ dict.standInfo.width }}:</label>
                <div class="col-sm-10">
                    <div class="input-group mb-3">   
                        <input v-model="width" type="text" class="form-control" id="inputWidth" name="inputWidth">
                        <div class="input-group-append">
                            <span class="input-group-text">{{ dict.standInfo.unit }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">{{ dict.frize.frizeName }}:</h3>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label for="frizeName" class="col-sm-2 col-form-label">{{ dict.frize.name }}:</label>
                <div class="col-sm-10">    
                    <div class="input-group mb-3">         
                        <input v-model="frizeName" type="text" class="form-control" id="frizeName" name="frizeName">
                        <div class="input-group-append">
                            <span class="input-group-text">{{paiedFrizeSigns}} {{ dict.frize.symbol }}</span>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text">x {{frizeDigitPrice}} {{ dict.valute }}</span>
                        </div>
                    </div>
                    <div>{{ dict.total.totalMsg }}: {{frizePrice | separate}} {{ dict.valute }}</div>
                </div>                
            </div>
        </div>
    </div>
    <h3 class="mt-4 mb-2">{{ dict.total.totalHead }}:</h3>
    <div class="py-2 px-3 mt-4">
                <h4 class="mb-0">
                 {{fullPrice | separate}} {{ dict.valute }}
                </h4>
     </div>
     <div class="card-footer">
                <button v-if="!isReadOnly" type="button" @click="saveDraft" class="btn btn-primary">{{ dict.buttons.draft }}</button>
                <button v-if="!isReadOnly" type="button" @click="formSubmit" class="btn btn-success">{{ dict.buttons.send }}</button>
                <button v-if="!isReadOnly" type="button" @click="cancel" class="btn btn-secondary">{{ dict.buttons.cancel }}</button>
                <button v-if="isReadOnly" type="button" @click="cancel" class="btn btn-secondary">{{ dict.buttons.close }}</button>
                </div>
</div>
</template>
<script>
import axios from "axios";
import { numberFormatMixin } from "./Mixins/numberFormatMixin"
import StandList from "./Stands";
export default {
    props: [
        'isReadOnly'
    ],    
    data() {
        return {
            update: false,
            id: null,
            standId: '',
            defaultSelectedStand: 1,
            title: '',
            width: '',
            length: '',
            square: 0,
            defaultSquare: null,
            standPrice: 0,
            frizeFreeDigits : 0,
            frizeDigitPrice : 0,
            frizeName : '',
            userId : null,
            draft: false,
            formData : new FormData(),
            addedFile: false,            
            stands: [],
            dict: {
                standPlan: {},
                standInfo: {},
                buttons: {},
                frize: {},
                total: {},
                fileAttach: {}
            },
            bus: new Vue()
        }
    },
    computed: {
        paiedFrizeSigns: function() {
            let symsLength = this.frizeName.replace(/[\s]/g,"").length;
            return (symsLength > this.frizeFreeDigits) ? symsLength - this.frizeFreeDigits : 0;
        },
        frizePrice: function() {
            return this.frizeDigitPrice * this.paiedFrizeSigns;
        },
        fullPrice: function() {
            return this.frizePrice + this.standPrice;
        }
    },
    components: {
        StandList
    },
    mixins: [
        numberFormatMixin
    ],
    methods: {
        fileLoad: function() {
            console.log('Файл загружен');
            this.formData.append('StandForm[loadedFile]', this.$refs.userFile.files[0]);
        },
        saveDraft: function() {
            this.draft = true;
            this.formSubmit();
        },
        cancel() {
            window.history.back();
        },
        formSubmit: function() {
            console.log('Форма отправлена');
            this.formData.append(
                'StandForm[standId]', this.standId
            );
            this.formData.append(
                'StandForm[draft]', +this.draft
            ); 
            console.log(this.draft);         
            this.formData.append(
                'StandForm[width]', this.width
            );
            this.formData.append(
                'StandForm[length]', this.length
            );                    
            this.formData.append(
                'StandForm[square]', this.square
            );
            this.formData.append(
                'StandForm[frizeName]', this.frizeName
            );
            this.formData.append(
                'StandForm[frizeDigitPrice]', this.frizeDigitPrice
            );            
            this.formData.append(
                'StandForm[userId]', this.userId
            );
            axios.post( '/api/stand/send-form',
                this.formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
                ).then(function(response){
                    location.href = '/panel/member/' + response.data.exhibitionId +'/requests';
                })
                .catch(function(){
                    location.href = '/panel/member/' + response.data.exhibitionId +'/requests';
                    console.log('FAILURE!!');
                });
        }

    },
  beforeCreate: function() {
    axios.get('/api/stand/get-form')
      .then((response) => {
        this.title = response.data.title;
        this.stands = response.data.stands;
        this.frizeDigitPrice = response.data.frizeDigitPrice;
        this.frizeFreeDigits = response.data.frizeFreeDigits;
        this.userId = response.data.userId;
        this.update = response.data.update;
        this.addedFile = response.data.fileName;
        this.dict = response.data.dict;
        console.log(response.data);
        if (Object.prototype.hasOwnProperty.call(response.data,'frizeName')) {
            this.frizeName = response.data.frizeName;
        }
        if (Object.prototype.hasOwnProperty.call(response.data,'width')) {
            this.width = response.data.width;
        }

        if (Object.prototype.hasOwnProperty.call(response.data,'length')) {
            this.length = response.data.length;
        }

        if (Object.prototype.hasOwnProperty.call(response.data,'square')) {
            console.log('data=' + response.data.square)
            this.defaultSquare = response.data.square;
        }
        if (Object.prototype.hasOwnProperty.call(response.data,'standId')) {
            this.defaultSelectedStand = response.data.standId;
        }
        this.id = response.data.id;
        this.bus.$emit('update',{ 
            'square' : this.defaultSquare,
            'stand' : this.defaultSelectedStand 
            });
      });        
  },    
}
</script>