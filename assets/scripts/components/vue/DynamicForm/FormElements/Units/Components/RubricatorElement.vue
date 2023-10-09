r<template>
    <li>
        <span :class="{rubric__checked : isChecked}" @click="isActive=!isActive">
            <i v-show="hasChildren" class="fa fa-chevron-down" aria-hidden="true"></i>{{ getName(name,nameEng) }}
            <i @click="addRubric" v-if="!isChecked" :title="getName('Добавить раздел', 'Add section')" v-show="!hasChildren" class="add-item far fa-plus-square"></i>
            <i @click="removeRubric" v-else :title=" getName('Удалить раздел', 'Remove section')" v-show="!hasChildren" class="remove-item far fa-minus-square"></i>
        </span>
        <ul v-show="isActive" v-if="hasChildren">
            <template v-for="rubric in rubrics.children"> 
              <rubricator-element :rubricsInCatalog="rubricsInCatalog" :rubrics="rubric"></rubricator-element>                      
        </template>
        </ul>
    </li>
</template>
<script>
import { textTranslateMixin } from '../Mixins/textTranslateMixin';

import { eventBus } from '../../../eventBus'
export default {
    name: "RubricatorElement",
    data() {
        return {
            isActive: false,
        }
    },
    props: [
        'rubrics',
        'rubricsInCatalog',
    ],
    mixins: [
        textTranslateMixin
    ],
    beforeCreate: function () {
        this.$options.components.RubricatorElement = require('./RubricatorElement.vue').default
    },     
    computed: {
        id() {
            return this.rubrics.id;
        },
        name() {
            return this.rubrics.name;
        }, 
        nameEng() {
            return this.rubrics.nameEng;
        },                
        hasChildren() {
            return this.rubrics.children.length > 0;
        },
        isChecked() {
            if (this.hasChildren) return false;
            //return //this.rubricsInCatalog // .eve
            let el = this.rubricsInCatalog.find((element) => {  
                if (element.id == this.id) {
                    return true;
                 } 
                 return false;
            });
            if (el) {
                return true;
            } else {
                return false;
            }

        }
    },
    methods: {
      addRubric() {
        let rubric = {
            'id': this.id,
            'name': this.name,
            'nameEng': this.nameEng
        };
       // console.log(rubric);
        eventBus.$emit('rubricWasAdded', rubric);
      },
      removeRubric() {
        eventBus.$emit('rubricWasDelete', this.id);
      }
     }
};
</script>
<style lang="css" scoped>
    i.add-item, i.remove-item {
        float: right;
        padding: 2px;
        cursor: pointer;
    }
</style>