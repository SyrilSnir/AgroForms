export const eventBus = new Vue({
    methods: {
        validate() {
            this.$emit('validate');
        },
        showErrors() {
            this.$emit('showErrors');
        }        
    }
});