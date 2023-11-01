import * as constants from '../../../utils/constants';
export const formList = {
    props: [
        'params'
    ], 
    created() {
        if(this.params.hasOwnProperty('value')) {
            this.formElements = this.params.value;
        }
        else if (!this.params.hasOwnProperty('badge_info')) {
            this.formElements.push({...this.defaultElement});
        } else {
            this.formElements.push({
                name: this.params.badge_info.name,
                middleName: this.params.badge_info.middle_name,
                surName: this.params.badge_info.surname,
                company: this.params.badge_info.company,                
            })
        }
        this.$emit('changeField',this.getData()); 
     },       
    data() {
        return {
            id: 'id' + this.params.id, 
            valid: true,           
            defaultElement: {},
            formElements: [
            ],            
        }
    },
    computed: {
        total() {
            let total = 0;
            if (!this.isComputed || this.freeCount >= this.nonEmptyBlocksCount) {
                return 0;
            }
            let val = this.nonEmptyBlocksCount - this.freeCount;
            total = val * (+this.unitPrice);
            if (isNaN(total)) {
                return 0;
            }
            return total;               
        },        
        blocksCount() {
            return this.formElements.length;
        },
        nonEmptyBlocksCount() {
            let elements = this.formElements.filter((item) => {
                switch(this.name) {
                    case constants.FORM_CONTACTS: 
                        return !(item.site == '' && item.email == '' && item.phone == '');
                    case constants.FORM_ADDRESS:
                        return !(item.country == '' && item.area == '' && item.city == '' && item.index == '' && item.address == '');
                    case constants.FORM_BADGE:
                        return !(item.name == '' && item.middleName == '' && itemsurName == '' && company == '');
                }
                return true;
            });
            return elements.length;
        },
        freeCount() {
            return this.params.parameters.freeCount;
        }
    },
    methods: {
        addFormBlock() {
            this.formElements.push({...this.defaultElement});
            this.$emit('changeField',this.getData());
        },
        removeItem(index) {
            this.formElements.splice(index,1);
            this.$emit('changeField',this.getData());            
        },
        onChange(event) {
            this.$emit('changeField',this.getData());
        },        
        getData() {
            let data = {
                id: this.id,
                data:  {
                    value: this.formElements,                       
                 },
                valid: this.valid
            };
            if (this.isComputed) {
                data.computed = true;
                data.total = this.total;
            }
            return data;            
        }               
     }    
}