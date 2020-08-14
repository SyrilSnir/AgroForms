export function formatWithSeparators(number) {
    let val = number.toString().replace(/[^0-9]/g, '');
    val = val.replace(/^0/, '');
    if (val == '') {
        val = '0';
    }
    val = val.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1 ');        

    return val;
}