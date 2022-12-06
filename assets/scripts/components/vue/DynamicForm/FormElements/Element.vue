<template>
    <div class="comp">
        <component :is="currentElement" :params="unitData" @changeField="fieldChanged" :lang="lang" :dic="dic"></component>
    </div>
</template>
<script>
import ImportantBlock from './Units/ImportantBlock';
import HeaderBlock from './Units/HeaderBlock';
import CheckBoxBlock from './Units/CheckBoxBlock';
import TextInputBlock from './Units/TextInputBlock';
import NumberInputBlock from './Units/NumberInputBlock';
import CheckNumberInput from './Units/CheckNumberInput';
import SelectBlock from './Units/SelectBlock';
import FriezeBlock from './Units/FriezeBlock';
import MultiSelectBlock from './Units/MultiSelectBlock';
import UndefinedBlock from './Units/UndefinedBlock';
import RadioBlock from './Units/RadioBlock';
import EquipmentBlock from './Units/EquipmentBlock';
import GroupBlock from './Units/GroupBlock';
import DateTimeBlock from './Units/DateTimeBlock';
import DateBlock from './Units/DateBlock';
import DateMultipleBlock from './Units/DateMultipleBlock';
import ImportantInformationBlock from './Units/ImportantInformation';
import FileBlock from './Units/FileBlock';
export default {
    props: [
        'unitData','lang','dic'
    ],
    components: {
        'important': ImportantBlock,
        'important-information': ImportantInformationBlock,
        'header-blck': HeaderBlock,
        'text-input': TextInputBlock,
        'number-input': NumberInputBlock,
        'check-number-input': CheckNumberInput,
        'checkbox': CheckBoxBlock,
        'select-input': SelectBlock,
        'multi-select-input': MultiSelectBlock,
        'radio': RadioBlock,
        'equipment': EquipmentBlock,
        'frieze': FriezeBlock,
        'group': GroupBlock,
        'date-multiple': DateMultipleBlock,
        'date-time': DateTimeBlock,
        'date': DateBlock,
        'file': FileBlock,
        'undefined': UndefinedBlock
    },    
    data() {
        return {
            typesList: {
                blockCheckbox: 1,
                blockSelect: 2,
                blockMultiSelect: 3,
                blockDate: 4,
                blockDateMultiple: 5,
                blockRadio: 6,
                blockNumberInput: 7,
                blockCheckNumber: 8,
                blockTextInput: 9,
                blockFile: 10,
                blockImportantInformation: 12,
                blockImportant: 13,
                blockHeader: 14,
                blockEquipment: 15,
                blockGroup: 16,
                blockFrieze: 17,
                blockDateTime: 18,
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
                case this.typesList.blockSelect:
                    return 'select-input';
                case this.typesList.blockRadio:
                    return 'radio';                    
                case this.typesList.blockMultiSelect:
                    return 'multi-select-input';                    
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
                case this.typesList.blockImportantInformation:
                    return 'important-information';
                case this.typesList.blockEquipment:
                    return 'equipment';  
                case this.typesList.blockFrieze:
                    return 'frieze';
                case this.typesList.blockDateTime:
                    return 'date-time';
                case this.typesList.blockDate:
                    return 'date';
                case this.typesList.blockDateMultiple:
                    return 'date-multiple';
                case this.typesList.blockGroup:
                    return 'group';
                case this.typesList.blockFile:
                    return 'file';
                default:
                    return 'undefined';
            }
        }
    }
}
</script>
<style></style>