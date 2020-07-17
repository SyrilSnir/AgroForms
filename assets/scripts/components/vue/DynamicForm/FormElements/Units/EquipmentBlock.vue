<template>
    <h2>Дополнительное оборудование!!!</h2>
</template>
<script>
import axios from "axios";    
export default {
    data() {
        return {
            categories: []
        }
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

</style>