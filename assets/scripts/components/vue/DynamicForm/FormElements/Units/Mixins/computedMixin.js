export const computedMixin = {
    data() {
        let basePrice, unitPrice;
        basePrice = this.params.parameters.hasOwnProperty('basePrice') ?
            +this.params.parameters.basePrice : 0;
        unitPrice = this.params.parameters.hasOwnProperty('unitPrice') ?
            +this.params.parameters.unitPrice : 0;         
        return {
            unitPrice,
            basePrice,
        }
    },
    computed: {
        isComputed() {
            return !!parseInt(this.params.parameters.isComputed);
        }
    }

}