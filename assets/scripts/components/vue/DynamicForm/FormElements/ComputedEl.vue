<template>
<div class="proposal-summary">
    <div class="proposal-summary__title">{{ dic.total.totalHead }}:</div>
    <div class="proposal-summary__total">
        {{ dic.total.totalMsg }}: {{ total | separate }} {{ dic.valute }}
    </div>
    <hr>
</div>
</template>
<script>
import { numberFormatMixin } from './Units/Mixins/numberFormatMixin'
export default {
       mixins: [
           numberFormatMixin
       ],
    props: [
        'total',
        'dic'
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