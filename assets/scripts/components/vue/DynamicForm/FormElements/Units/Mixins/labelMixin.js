import { languages } from '../../../../lang'
export const labelMixin = {
    computed: {
        titleLabel() {
            if (this.lang == languages.russian || !this.params.name_eng) {
                return this.params.name;
            }
            return this.params.name_eng;               
        }
    },    
}