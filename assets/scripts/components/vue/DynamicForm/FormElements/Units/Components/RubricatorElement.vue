r<template>
    <li>
        <span v-if="canBeShowed" @click="isActive=!isActive"><i v-show="hasChildren" class="fa fa-chevron-down" aria-hidden="true"></i>{{ name }}<i  @click="addRubric" title="Добавить раздел" v-if="!hasChildren" class="add-item far fa-plus-square"></i></span>
        <ul v-show="isActive" v-if="hasChildren">
            <template v-for="rubric in rubrics.children"> 
              <rubricator-element :rubricsInCatalog="rubricsInCatalog" :rubrics="rubric"></rubricator-element>                      
        </template>
        </ul>
    </li>
</template>
<script>
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
        hasChildren() {
            return this.rubrics.children.length > 0;
        },
        canBeShowed() {
            if (this.hasChildren) return true;
            //return //this.rubricsInCatalog // .eve
            let el = this.rubricsInCatalog.find((element) => {  
                console.log(element.id,this.id);
                if (element.id == this.id) {
                    return true;
                 } 
                 return false;
            });
            console.log(el);
            if (el) {
                return false;
            } else {
                return true;
            }

        }
    },
    methods: {
      addRubric() {
        let rubric = {
            'id': this.id,
            'name': this.name,
        };
        console.log(rubric);
        eventBus.$emit('rubricWasAdded', rubric);
      }
     }
};
</script>
<style lang="css" scoped>
    i.add-item {
        float: right;
        padding: 2px;
        cursor: pointer;
    }
</style>