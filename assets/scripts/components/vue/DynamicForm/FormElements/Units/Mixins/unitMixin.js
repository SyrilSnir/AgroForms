export const unitMixin = {
    props: [
        'params'
    ],
    data() {
        return {
            parameters: this.params.parameters,                         
            required: this.params.parameters.required,
            unit: this.params.parameters.unitName, 
        //    val: this.params.value
        }
    }       
}