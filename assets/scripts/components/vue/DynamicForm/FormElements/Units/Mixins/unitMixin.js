export const unitMixin = {
    props: [
        'params'
    ],
    data() {
        return {
            parameters: this.params.parameters, 
            unit: this.params.parameters.unitName 
        //    val: this.params.value
        }
    },
    computed: {
        required() {
            return !!this.params.parameters.required;
        }
    }      
}