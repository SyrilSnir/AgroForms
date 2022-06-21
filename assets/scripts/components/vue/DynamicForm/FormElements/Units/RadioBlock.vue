<template>
<div class="form-group">
    <div class="label">{{ params.name }}</div>
                        <div v-for="element in enums" class="form-check">
                          <input @change="change" class="form-check-input" type="radio" v-model="selected" :name="id" :value="element.id">
                          <label class="form-check-label">{{ element.name }}</label>
                        </div>
                      </div>    
</template>
<script>
import { unitMixin } from './Mixins/unitMixin';    
import { selectMixin } from './Mixins/selectMixin';
import { computedMixin } from './Mixins/computedMixin'; 
export default {
    data() {
        return {
            id: 'id' + this.params.id, 
            val: this.params.value,   
            valid : true,
            selected: this.params.value
        }
    },
    created() {
        this.$emit('changeField',this.getData());
    },      
    methods: {
        change() {
            this.params.value = this.selected;
            this.$emit('changeField',this.getData());               
        },            
        getData() {
            let data = {
                id: this.id,
                data:  {
                    value: this.selected,                       
                },
                valid: this.valid                   
            }
            if (this.isComputed) {
                data.computed = true;
                data.total = this.total;
            }
            return data;
        }
    },    
    computed: {
        total() {
            let total = 0;
            if (!this.isComputed) {
                return 0;
            }
            for (const el of this.enums) {
                if (el.id == this.selected) {
                    total = +el.value;
                }                   
            }
            if (isNaN(total)) {
                return 0;
            }
            return  total;
        }
    },     
    mixins: [
        unitMixin,
        selectMixin,
        computedMixin
    ],
}
</script>
<style scoped>
    .label {
        font-weight: bold;
    }
</style>