<template>
    <div class="block__rubricator">
       <div @click="isActive=!isActive" class="main"><span :class="{ active: isActive}"><i class="fa fa-chevron-down" aria-hidden="true"></i>{{ titleLabel }}</span></div>
        <template v-for="rubric in rubrics[0].children"> 
            <ul class="wtree">
              <rubricator-element :rubricsInCatalog="selected" v-show="isActive" :rubrics="rubric" :lang="lang"></rubricator-element>
            </ul>                       
        </template>
        <div class="card">
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th colspan="3">{{ getName('Выбранные рубрики', 'Selected categories') }}</th>
                    </tr>
                  </thead>
                  <tbody>                    
                    <tr v-for="(el,index) in selected" :key="index">
                      <td>{{ index + 1 }}</td>
                      <td>{{ getName(el.name,el.nameEng) }}</td>
                      <td><i @click="removeRubric(index)" class="far fa-times-circle"></i></td>
                    </tr>
                    <tr v-if="isComputed">
                      <th class="total">{{ dic.total.totalMsg }}:</th><th colspan="2" style="text-align: right;">{{ total | separate }} {{ dic.valute }}</th>
                  </tr>                    
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
    </div> 
 </template>
 <script>
 import RubricatorElement from './Components/RubricatorElement';
 import { computedMixin } from './Mixins/computedMixin';
import { labelMixin } from './Mixins/labelMixin';
import { textTranslateMixin } from './Mixins/textTranslateMixin';
import { numberFormatMixin } from './Mixins/numberFormatMixin';

 import { eventBus } from '../../eventBus'
 export default {
     data() {
        return {
            id: 'id' + this.params.id,
            loaded: false,
            rubrics: [[]],
            isActive: false,
            valid: true,            
            selected: []
        }
     },
     props: ['params','dic','lang'],
     mixins: [
      computedMixin,
      labelMixin,
      textTranslateMixin,
      numberFormatMixin
     ],
     components : {
        RubricatorElement
     },
     created() {
       if(this.params.hasOwnProperty('value')) {
         this.selected = this.params.value;
         this.getData();
        }        
        this.$emit('changeField',this.getData());
        fetch('/api/rubricator/get-list').then(response => {
            response.json().then(data => {
                console.log(data);
                this.loaded = true;                
                this.rubrics = data;
                eventBus.$on('rubricWasAdded', (data) => {
                    this.selected.push(data);
                    this.$emit('changeField',this.getData());
                });
                eventBus.$on('rubricWasDelete', (data) => {
                    let itemIndex =this.selected.findIndex((el) => {
                      return (el.id == data)
                    });
                    if (itemIndex >= 0) {
                      this.removeRubric(itemIndex);
                    }
                });
            })
        })
     },
     computed: {
      rubricsCount() {
          return this.selected.length;
      },
      freeCount() {
            return this.params.parameters.freeCount;
      },
      total() {
            let total = 0;
            if (!this.isComputed || this.freeCount >= this.rubricsCount) {
                return 0;
            }
            let val = this.rubricsCount - this.freeCount;
            total = val * (+this.unitPrice);
            if (isNaN(total)) {
                return 0;
            }
            return total;               
        },       
     },
     methods: {
      removeRubric(index) {
        this.selected.splice(index,1);
        this.$emit('changeField',this.getData());
      },
      getData() {
            let data = {
                id: this.id,
                data:  {
                    value: this.selected,                       
                 },
                valid: this.valid
            };
            if (this.isComputed) {
                data.computed = true;
                data.total = this.total;
            }
            return data;            
        }       
     }
 }
 </script>
 <style scope>
 .block__rubricator span > i {
    padding: 10px;
    transition: transform 0.2s ease-in-out;
 }
 .block__rubricator span.active > i {
    transform: rotate(180deg);
 }
 .block__rubricator .main {
    /* padding: 15px 15px 15px 45px; */
    font-size: 18px;
    font-weight: 700;
 }
ul {
    margin-left: 20px;
    margin-bottom: 0;
}

.wtree li {
  list-style-type: none;
   margin: 2px 0 2px 5px;
  position: relative;
}
.wtree li:before {
  content: "";
  position: absolute;
  top: -10px;
  left: -20px;
  border-left: 1px solid #ddd;
  border-bottom: 1px solid #ddd;
  width: 20px;
  height: 15px;
}
.wtree li:after {
  position: absolute;
  content: "";
  top: 5px;
  left: -20px;
  border-left: 1px solid #ddd;
  border-top: 1px solid #ddd;
  width: 20px;
  height: 100%;
}
.wtree li:last-child:after {
  display: none;
}
.wtree li span {
  display: block;
  border: 1px solid #ddd;
  padding: 2px; 
  color: #000;
  text-decoration: none;
}
.wtree li span.rubric__checked {
  background: #EFA281;  
}
.wtree li span:hover, .wtree li span:focus {
  background: #EFA281;
  color: #000;
  border: 1px solid #aaa;
}
.wtree li span:hover + ul li span, .wtree li span:focus + ul li span {
  background: #EFA281;
  color: #000;
  border: 1px solid #aaa;
}
.wtree li span.rubric__checked:hover, .wtree li span.rubric__checked:focus {
  background: #e2d4ce;
  color: #000;
  border: 1px solid #aaa;
}
.wtree li span:hover + ul li span.rubric__checked, .wtree li span:focus + ul li span.rubric__checked {
  background: #e2d4ce;
  color: #000;
  border: 1px solid #aaa;
}
.wtree li span:hover + ul li:after, .wtree li span:hover + ul li:before, .wtree li span:focus + ul li:after, .wtree li span:focus + ul li:before {
  border-color: #aaa;
}     

 </style>