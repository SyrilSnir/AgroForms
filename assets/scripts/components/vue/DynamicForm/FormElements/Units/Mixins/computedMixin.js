export const computedMixin = {
    data() {
        return {
            isComputed: this.params.parameters.isComputed, 
            unitPrice: +this.params.parameters.unitPrice,
            basePrice: +this.params.parameters.basePrice,
        }
    }       
}