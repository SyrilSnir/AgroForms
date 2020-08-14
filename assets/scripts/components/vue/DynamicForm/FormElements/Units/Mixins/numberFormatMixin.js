import { formatWithSeparators } from '../../../../../utils/numbers'
export const numberFormatMixin = {
    filters: {
        separate(val) {
            return formatWithSeparators(val);
        }
    }
}