<template>
    <div class="equipments-list__container">
        <ul class="additional-equipment__list">
            <template v-for="(category,index) in categories">
            <li v-if="isShowed(category.id)" :key="index">
                <span @click="expand(category.id)">{{ getName(category.name, category.name_eng) }}</span>
                <equipment-list 
                    :val="values"
                    :id="category.id"
                    :eventBus="bus"
                    :dic="dic"
                    :lang="lang"
                    @changeValue="setValue"                  
                ></equipment-list>            
            </li>
            </template>

        </ul>
        <table class="table">
            <tbody>
                <tr v-for="(val,key) in values" :key="key">                    
                    <td>{{ val.code }}</td>
                    <td>{{ getName(val.name,val.name_eng) }}</td>
                    <td>{{ val.count | separate }} {{ getName(val.unit.short_name, val.unit.short_name_eng) }}</td>
                    <td>x{{ val.price | separate }} {{ dic.valute }}</td>
                    <td>={{ (val.price * val.count) | separate }} {{ dic.valute }}</td>                    
                </tr>
                <tr v-if="isComputed">
                    <td colspan="5" class="total">{{ dic.total.totalMsg }}: {{ total | separate }} {{ dic.valute }}</td>
                </tr>
            </tbody>
        </table>
    </div>

</template>
<script>
import { unitMixin } from './Mixins/unitMixin'
import { computedMixin } from './Mixins/computedMixin'
import { numberFormatMixin } from './Mixins/numberFormatMixin'
import { textTranslateMixin } from './Mixins/textTranslateMixin'
import axios from "axios"
import EquipmentList from "./Components/EquipmentList"
export default {
    props: [
        'dic',
        'lang'
    ],
    data() {   
        let val = {};
        if (this.params.value) {
            val = this.params.value;
        }

        return {
            id: 'id' + this.params.id,
            categories: [],
            availableCategories: this.params.parameters.categories,
            allCategories: (this.params.parameters.allCategories == true),
            bus: new Vue(),// Шина событий
            values: val,
        }
    },
    computed: {
        total() {
            let total = 0;
            if (!this.isComputed ) {
                return total;
            }
            let currentVal;
            const keys = Object.keys(this.values);            
            for (const key of keys) {
                currentVal = Number.parseInt(this.values[key].count) * Number.parseInt(this.values[key].price);
                if (!isNaN(currentVal)) {
                    total+= currentVal;
                }
            }
            return total;
        }
    },
    mixins: [
        unitMixin,
        numberFormatMixin,
        textTranslateMixin,
        computedMixin,
    ],
    components: {
        EquipmentList
    },
    methods: {
        isShowed(id) {
            console.log('Id = ', id);
            return ( this.allCategories || this.availableCategories.indexOf(id) !== -1);
        },
        expand(id) {
            this.bus.$emit('expand',id);
        },
        setValue(equipment,count) {
            const index = +equipment.id;
            if (count > 0) {
                Vue.set(this.values, index, {
                    name: this.getName(equipment.name, equipment.name_eng),
                    code: equipment.code,
                    unit: equipment.unit.short_name,
                    id: equipment.id,
                    count: count,
                    price: equipment.price                    
                });
            } else {
                Vue.delete(this.values,index);
            }
            this.$emit('changeField',this.getData());
        },
           onChange(event) {
               this.showErrors = false;
                this.$emit('changeField',this.getData());
           },       
        getData() {
            let values = [];
            for (let key in this.values) {
                values.push({
                    id: this.values[key].id,
                    count: this.values[key].count,
                    price: this.values[key].price,
                });
            }
            let data = {
                id: this.id,
                data: {
                    value: values
                },
                valid: true
            };
            if (this.isComputed) {
                data.computed = true;
                data.equip = true;
                data.total = this.total;
            }            
            return data;
        }
    },
    beforeCreate: function() {
        axios.get('/api/equipment/get-categories')
            .then((response) => {
                this.categories = response.data;
            });
    },
    created() {        
        this.$emit('changeField',this.getData());
    }
}
</script>
<style scoped>
    .additional-equipment__list li {
        cursor: pointer;
    }
    td.total {
        text-align: right;
        font-weight: bold;
    }
</style>