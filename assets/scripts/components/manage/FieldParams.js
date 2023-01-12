const $ = window.$;
export default class FieldParams {
    constructor() {
        const fieldsConfig = $('#fields-config');
        this.$elementTypeSelector = $('#element-type-selector'); 
        this.attachmentType = fieldsConfig.data('attachment');
        this.$enumWrapper = $('#attribute-enums-wrapper');        
        this.$elementTypeSelector.on('change',this.elementTypeSelectorChangeHandler.bind(this));       
        this.textType = fieldsConfig.data('text');
        this.htmlType = fieldsConfig.data('html');
        this.numberType = fieldsConfig.data('number');
        this.computedType = fieldsConfig.data('computed');
        this.requiredType = fieldsConfig.data('required');
        this.enumValues = fieldsConfig.data('enums'); 
        this.equipment = fieldsConfig.data('equipment');
        this.frieze = fieldsConfig.data('frieze');
        this.group = fieldsConfig.data('group');
        this.$htmlParamsBlock = $('#html-params');
        this.$numberParamsBlock = $('#number-params');
        this.$requiredBlock = $('#required-block');
        this.$computedBlock = $('#computed');
        this.$attachmentBlock = $('#attachment');
        this.$textParamsBlock = $('#text-params');
        this.$equipmentBlock = $('#additional-equipment');
        this.$friezeBlock = $('#frieze-params');
        this.$groupBlock = $('#group-params');
    }
    elementTypeSelectorChangeHandler(e) {
        const value = parseInt(e.target.value);
        console.log(value,this.textType,this.htmlType,this.computedType);

        if(this.enumValues.indexOf(value) !== -1) {
            this.$enumWrapper.removeClass('hide');
            $('#unit-price__container').hide();
        } else {
            this.$enumWrapper.addClass('hide');
            $('#unit-price__container').show();
        }
        (this.textType.indexOf(value) !== -1) ?
            this.textParamsShow(true) :
            this.textParamsShow(false);
        (this.htmlType.indexOf(value) !== -1) ?
            this.htmlParamsShow(true) :
            this.htmlParamsShow(false);  
        (this.attachmentType.indexOf(value) !== -1) ?
            this.attachmentParamsShow(true):
            this.attachmentParamsShow(false);
        (this.requiredType.indexOf(value) !== -1) ?
            this.requiredShow(true) :
            this.requiredShow(false);
        (this.numberType.indexOf(value) !== -1) ?
            this.numberParamsShow(true) :
            this.numberParamsShow(false);  
        (this.computedType.indexOf(value) !== -1) ?
            this.computedParamsShow(true) :
            this.computedParamsShow(false);
        (this.equipment == value) ? 
            this.equipmentParamShow(true) :
            this.equipmentParamShow(false);
        (this.frieze == value) ?
            this.friezeParamShow(true):
            this.friezeParamShow(false);
        (this.group == value) ?
            this.groupParamShow(true):
            this.groupParamShow(false);
    }
    computedParamsShow( isShow ) {
        isShow ? 
            this.$computedBlock.removeClass('hide') :
            this.$computedBlock.addClass('hide');           
    }     
    numberParamsShow( isShow ) {
        isShow ? 
            this.$numberParamsBlock.removeClass('hide') :
            this.$numberParamsBlock.addClass('hide');
    }    
    textParamsShow( isShow ) {
        isShow ? 
            this.$textParamsBlock.removeClass('hide') :
            this.$textParamsBlock.addClass('hide');
    }
    attachmentParamsShow( isShow ) {
        isShow ?
            this.$attachmentBlock.removeClass('hide'):
            this.$attachmentBlock.addClass('hide');
    }
    requiredShow( isShow ) {
        isShow ? 
            this.$requiredBlock.removeClass('hide') :
            this.$requiredBlock.addClass('hide');
    }    
    htmlParamsShow( isShow ) {
        isShow ? 
            this.$htmlParamsBlock.removeClass('hide') :
            this.$htmlParamsBlock.addClass('hide');
    }
    equipmentParamShow( isShow ) {
        isShow ? 
            this.$equipmentBlock.removeClass('hide') :
            this.$equipmentBlock.addClass('hide');
    }
    friezeParamShow( isShow ) {
        isShow ? 
            this.$friezeBlock.removeClass('hide') :
            this.$friezeBlock.addClass('hide');
    }    
    groupParamShow( isShow ) {
        isShow ? 
            this.$groupBlock.removeClass('hide') :
            this.$groupBlock.addClass('hide');
    }    
}