<template>
<div class="proposal-summary">
    <div class="proposal-summary__title">Общая стоимость по заявке:</div>
    <div class="proposal-summary__total">
        Итого: {{ total }} руб
    </div>
    <hr>
</div>
</template>
<script>
export default {
    props: [
        'total'
    ],
    data() {
        return {
          //  total: 0
        }
    }
}
</script>
<style lang="">
    
</style>