<template>
    <div class="file-block">
        <div v-if="!isFileExist" class="form-group">
            <p class="d-flex flex-column">
                    <span>{{ titleLabel }}</span>
                </p>             
<div class="input-group" v-if="isFileSelect">
    <input class="form-control" :value="selectedFile" type="text" readonly>
    <div class="input-group-append">
        <div @click="cancelUpload" class="input-group-text"><i class="fas fa-times"></i><span>Cancel</span></div>
    </div>    
</div>
<div v-else class="custom-file">
    <input @change="onChange" :id="id" :ref="id" type="file" :accept="mimeFilter" class="custom-file-input">
    <label class="custom-file-label input-group-text" :data-browse="dic.fileAttach.browse" :for="id">Select file</label>
</div>
</div>
<div v-else>
    <div class="container file__wrapper">
        <div class="file__title">
            <span>{{ titleLabel }}</span>
        </div>  
        <div class="row file__list">
            <div class="col-11">
                <a :href="fileUrl">{{ fileName }}</a>
            </div>
            <div class="col-1"><i @click="removeFile" class="fas fa-trash"></i></div>
        </div>
  </div>


</div>
</div>
</template>
<script>  
import { labelMixin } from './Mixins/labelMixin';
import { computedMixin } from './Mixins/computedMixin';
import * as constants from '../../utils/constants';
import axios from 'axios';
export default {
    data() {
        return {
            id: 'id' + this.params.id,
            val: null,
            isFileSelect: false,
            selectedFile: '',

        }
    },
    created() {
        this.$emit('changeField',this.getData());
    },
    computed: {
        isFileExist() {
            return this.params.file_exist;
        },
        fileUrl() {
            return this.params.file_url;
        },
        fileName() {
            return this.params.file_name;
        },
        requestId() {
            return this.params.request_id;
        },
        mimeFilter() {
            return this.params.file_types;
        },
        total() {
            let total = 0;
            if (!this.isComputed && !(this.isFileExist || this.isFileSelect)) {
                return 0;
            }
            total = +this.unitPrice;
            if (isNaN(total)) {
                return 0;
            }
            return total;               
        },        
    },
    props: [
        'params',
        'dic',
        'lang'
    ],    
    mixins: [
        labelMixin,
        computedMixin
    ],
    methods: {
        onChange(e) {
            this.val = e.target.files[0];            
            this.selectedFile = this.val.name;
            this.isFileSelect = true;
            this.$emit('changeField',this.getData());            
            //console.log(e.target.files[0]);
        },
        cancelUpload() {
            this.val = null;
            this.selectedFile = '';
            this.isFileSelect = false;            
            this.$emit('changeField',this.getData());             
        },
        getData() {
            let data = {
                id: this.params.id,                  
                file: this.val,
                valid: true,
                data: {
                    value: this.unitPrice,
                },
                [constants.ATTACHMENT_ATTRIBUTE]: true,
            };
            if (this.isComputed) {
                   data.computed = true;
                   data.total = this.unitPrice;
            }            
            return data;
        },  
        removeFile() {
            const formData = new FormData();
            formData.append("RemoveAttachmentForm[requestId]",this.requestId);
            formData.append("RemoveAttachmentForm[fieldId]", this.params.id);
            axios.post( '/api/application/remove-attachment',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then((response) => {
                this.params.file_exist = false;
                this.$emit('changeField',this.getData());               
            }).catch((error) => {
                console.log("FAILURE!!!");
                console.log(error);
            })
        }
    }
}
</script>
<style scoped>
i {
    margin-right: 5px;
}
.input-group-text {
    cursor: pointer;
}
.file__wrapper {
    border: 1px inset lightgray;
    text-align: center;
    margin: 20px 0;
}

.file__title {
    padding: 5px;
}
.file__list {
    border-top:  1px inset lightgray;    
    padding: 10px 20px;
}
.col-11 {
    border-right:  1px inset lightgray;
    text-align: left;
}

.col-1 i {
    color: red;
    cursor: pointer;
}
</style>