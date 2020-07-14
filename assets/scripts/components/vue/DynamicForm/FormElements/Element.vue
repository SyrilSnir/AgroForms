<template>
    <div class="comp">
        <component :is="currentElement" :params="unitData" @changeField="fieldChanged"></component>
    </div>
</template>
<script>
import ImportantBlock from './Units/ImportantBlock';
import HeaderBlock from './Units/HeaderBlock';
import CheckBoxBlock from './Units/CheckBoxBlock';
import TextInputBlock from './Units/TextInputBlock';
import NumberInputBlock from './Units/NumberInputBlock';
import CheckNumberInput from './Units/CheckNumberInput';
export default {
    props: [
        'unitData'
    ],
    components: {
        important: ImportantBlock,
        'header-blck': HeaderBlock,
        'text-input': TextInputBlock,
        'number-input': NumberInputBlock,
        'check-number-input': CheckNumberInput,
        'checkbox': CheckBoxBlock
    },    
    data() {
        return {
            typesList: {
                blockCheckbox: 1,
                blockNumberInput: 7,
                blockCheckNumber: 8,
                blockTextInput: 9,
                blockImportant: 13,
                blockHeader: 14
            }
        }
    },
    methods: {
        fieldChanged(field) {
            this.$emit('modification', field);
        }
    },
    computed: {
        currentElement() {
            switch (parseInt(this.unitData.element_type_id)) {
                case this.typesList.blockCheckbox:
                    return 'checkbox';
                case this.typesList.blockNumberInput:
                    return 'number-input';                    
                case this.typesList.blockTextInput:
                    return 'text-input';
                case this.typesList.blockCheckNumber:
                    return 'check-number-input';    
                case this.typesList.blockImportant:
                    return 'important';
                case this.typesList.blockHeader:
                    return 'header-blck';
                default:
                    return 'undefined';
            }
        }
    }
}
</script>
<style></style>