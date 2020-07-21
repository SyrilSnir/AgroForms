<template>
    <div v-if="expand" class="container">
        <div v-for="(equipment,index) in equipments" class="form-group">
            <label :for="getId(equipment.id)">{{ equipment.name }}</label>
            <div class="input-group">
                <input 
                    @change="setVal(equipment,inputs[equipment.id])" v-model="inputs[equipment.id]" class="form-control" type="text" placeholder="Enter ...">
                <div class="input-group-append">
                    <span class="input-group-text">{{ equipment.unit.short_name }}</span>
                </div>
                <div class="input-group-append">
                    <span class="input-group-text">x<span class="price">{{ +equipment.price }}</span> РУБ</span>
                </div>
                <div class="input-group-append">
                    <span class="input-group-text">=<span class="price">{{ getTotalPrice(equipment,+inputs[equipment.id]) }}</span> РУБ</span>
                </div>                                   
            </div>          
        </div>
    </div>
</template>
<script>
import axios from "axios"; 
export default {
    props: [
        'id',
        'eventBus',
        'val'
    ],
    data() {
        return {
            equipments: [],
            isLoaded: false,
            expand: false,
            inputs: []
        }
    },
    created() {
        this.eventBus.$on('expand',this.expandElement);        
    },
    methods: {
        setVal(equipment,count) {
            let eq = {};
            Object.assign(eq, equipment);            
            this.$emit('changeValue',eq,count);
        },
        isNumber(val) {            
            return /^\d+$/.test(val);
        },
        expandElement(id) {
            if (id === this.id) {
                this.expand = !this.expand;
                if (!this.isLoaded) {
                    this.getEquipments();
                    this.isLoaded = true;
                }
            }
        },
        getId(id) {
            return 'equipment-' + id;
        }, 
        getEquipments() {
            axios.get('/api/equipment/get-equipments?categoryId=' + this.id)
                .then((response) => {
                    this.equipments = response.data;
                    const eqKeys = Object.keys(this.equipments);
                    for (const key of eqKeys) {                                              
                        if (this.val.hasOwnProperty(key)) {
                            this.inputs[key] = this.val[key].count;
                        }
                    }
                })
        },
        getTotalPrice(equipment,count) {
            let sum = 0;
            sum = (count > 0) ? count * equipment.price : 0;            
            return sum;

        }
    }
}
</script>
<style scoped>

</style>