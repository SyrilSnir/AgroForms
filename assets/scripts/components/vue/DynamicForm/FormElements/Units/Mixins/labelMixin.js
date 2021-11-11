import { languages } from '../../../../lang'
export const labelMixin = {
    computed: {
        titleLabel() {
            if (this.lang == languages.russian || !this.params.name_eng) {
                return this.params.name;
            }
            return this.params.name_eng;               
        },
        descriptionLabel() {
            if (this.lang == languages.russian || !this.params.description_eng) {
                return this.params.description;
            }
            return this.params.description;
        }        
    },    
}