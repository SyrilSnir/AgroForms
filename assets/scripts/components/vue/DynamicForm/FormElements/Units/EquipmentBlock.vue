<template>
    <ul class="additional-equipment__list">
        <li v-for="category in categories">{{ category.name }}
            <equipment-list></equipment-list>
        </li>
    </ul>
</template>
<script>
import axios from "axios";    
import EquipmentList from "./Components/EquipmentList";
export default {
    data() {
        return {
            categories: []
        }
    },
    components: {
        EquipmentList
    },    
    beforeCreate: function() {
        axios.get('/api/equipment/get-categories')
            .then((response) => {
                this.categories = response.data;
            });
    }
}
</script>
<style scoped>
    .additional-equipment__list li {
        cursor: pointer;
    }
</style>