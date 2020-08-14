<template>
    <div class="equipments-list__container">
        <ul class="additional-equipment__list">
            <li v-for="category in categories">
                <span @click="expand(category.id)">{{ category.name }}</span>
                <equipment-list 
                    :val="values"
                    :id="category.id"
                    :eventBus="bus"
                    :dic="dic"
                    @changeValue="setValue"                  
                ></equipment-list>            
            </li>
        </ul>
        <table class="table">
            <tbody>
                <tr v-for="(val,key) in values">                    
                    <td>{{ val.code }}</td>
                    <td>{{ val.name }}</td>
                    <td>{{ val.count | separate }} {{ val.unit }}</td>
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
import axios from "axios"
import EquipmentList from "./Components/EquipmentList"
export default {
    props: [
        'dic'
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
            values: val
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
        numberFormatMixin
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
              /*  this.values.splice(index,1,{
                    name: equipment.name,
                    unit: equipment.unit.short_name,
                    count: count,
                    price: equipment.price
                });*/
                Vue.set(this.values, index, {
                    name: equipment.name,
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
        getData() {
            let data = {
                id: this.id,
                data: {
                    value: this.values
                },
                valid: true
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