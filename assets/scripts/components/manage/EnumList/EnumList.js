const $ = window.$;
export default class EnumList {
    constructor(selector) {
        const $container = $(selector);
        this.$addEnumFieldButton = $container.find('.enum-field-add-button');
        this.$enumList = $container.find('.attributes-enum-table tbody');
        this.$enumFieldName = $container.find('.enum-field-name');
        this.$enumFieldValue = $container.find('.enum-field-value');
        this.enumsArray = [];
    }
    init() {
        this.initEnumsList();
        this.$addEnumFieldButton.on('click',this.addEnumeFieldHandler.bind(this));
        this.$enumList.on('click','.delete-enum-field', this.deleteEnumFieldHandler.bind(this));
    }
    addEnumeFieldHandler() {
        const name = this.$enumFieldName.val();
        const value = this.$enumFieldValue.val();
        const index = this.$enumList.find('tr').length + 1;
        const template = `<tr data-number="${index}">
                            <td>${index}.</td>
                            <td class="attribute-enum-name">${name}</td>
                            <td class="attribute-enum-value">${value}</td>
                            <td>    
                                <a class="btn btn-app delete-enum-field">
                                    <i class="fas fa-times"></i>Удалить
                                </a> 
                            </td>
                        </tr>`;
        if (
            name.trim() !== '' &&
            value.trim() !== ''
            ) {
            this.enumsArray.push({
                'name': name,
                'value': value,
            });
            this.saveToSession();
            this.$enumList.append(template);            
        }
    }
    deleteEnumFieldHandler(e) {
        const $targetRow = $(e.target).closest('tr');
        let lastRow = false;
        if ($targetRow.next('tr').length == 0) {
            lastRow = true;
        }
        let arrayIndex = $targetRow.data('number') - 1;        
        this.enumsArray.splice(arrayIndex,1);
        console.log(this.enumsArray);
        $targetRow.remove();
        this.saveToSession();
        if (!lastRow) {
            this.indexRerender();
        }

    }
    initEnumsList() {
        const $rows = this.$enumList.find('tr');
        this.enumsArray = $rows.map(function(index,row) {

            return {                
                'name' : $(row).find('.attribute-enum-name').text(),
                'value' : $(row).find('.attribute-enum-value').text()                
            }
        }).get();
    }
    indexRerender() {
        const $trs = this.$enumList.find('tr');
        $trs.each(function(index,tr){
            $(tr).data('number',index+1);
            $(tr).find('td:first').text(index+1);
        });
    }
    saveToSession() {
        $.ajax({
            url: '/api/parameters/save-enums-list',
            type: 'POST',
            dataType: "json",
            data: { 
                list : this.enumsArray                                               
            }
        });
    }
}