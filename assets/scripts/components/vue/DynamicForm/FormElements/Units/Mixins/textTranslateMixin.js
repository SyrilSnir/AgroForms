import { languages } from '../../../../lang'
export const textTranslateMixin = {
    methods: {
        getName(val,valEng) {
            if ((this.lang == languages.russian) || !valEng) {
                return val;
            }
            return valEng;
        }, 
    },    
}