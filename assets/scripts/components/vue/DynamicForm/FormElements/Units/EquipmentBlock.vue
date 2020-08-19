<template>
    <div class="equipments-list__container">
        <ul class="additional-equipment__list">
            <li v-for="category in categories">
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
        </ul>
        <table class="table">
            <tbody>
                <tr v-for="(val,key) in values">                    
                    <td>{{ val.code }}</td>
                    <td>{{ getName(val.name,val.name_eng) }}</td>
                    <td>{{ val.count | separate }} {{ getName(val.unit.short_name, val.unit.short_name_eng) }}</td>
                    <td>x{{ val.price | separate }} {{ dic.valute }}</td>
                    <td>={{ (val.price * val.count) | separate }} {{ dic.valute }}</td>                    
                </tr>
                <tr>
                    <td colspan="5" class="total">{{ dic.total.totalMsg }}: {{ total | separate }} {{ dic.valute }}</td>
                </tr>
            </tbody>
        </table>
    </div>

</template>
<script>
import { unitMixin } from './Mixins/unitMixin'
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
            bus: new Vue(),// Шина событий
            values: val,
            isComputed: true,
        }
    },
    computed: {
        total() {
            let total = 0;
            const keys = Object.keys(this.values);
            for (const key of keys) {
                total+= this.values[key].count * this.values[key].price;
            }
            return total;
        }
    },
    mixins: [
        unitMixin,
        numberFormatMixin,
        textTranslateMixin
    ],
    components: {
        EquipmentList
    },
    methods: {
        expand(id) {
            console.log('Expand= ' + id);
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
            let data = {
                id: this.id,
                data: {
                    value: this.values
                },
                valid: true
            };
            if (this.isComputed) {
                data.computed = true;
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