export const computedMixin = {
    data() {
        return {
            unitPrice: +this.params.parameters.unitPrice,
            basePrice: +this.params.parameters.basePrice,
        }
    },
    computed: {
        isComputed() {
            return !!parseInt(this.params.parameters.isComputed);
        }
    }

}