<template>
    <div class="header__block">
        <h4>{{ header }}</h4>
        <p class="description">{{ desc }}</p>
        <p class="info">{{ title }}</p>
    </div>
</template>
<script>
    import { unitMixin } from './Mixins/unitMixin'
    import { languages } from '../../../lang'    
    export default {
        props: [
            'lang'
        ],        
       mixins: [
           unitMixin
       ],
       computed: {
           title() {
               // this.parameters.html
                return (this.lang == languages.russian || !this.parameters.textEng) ?
                    this.parameters.text :               
                    this.parameters.textEng;
           },
           header() {
                return (this.lang == languages.russian || !this.params.textEng) ?
                    this.params.name :
                    this.params.name_eng;
           },
           desc() {
                return (this.lang == languages.russian || !this.params.textEng) ?
                    this.params.description :
                    this.params.description_eng;
           }

       }       
    }
</script>
<style scoped>
p {
    margin-bottom: 0;
}
.description {    
}
.info {
    font-size: .9rem;
    color: #686868;
}
</style>