const $ = window.$;
export default class FieldParams {
    constructor() {
        const fieldsConfig = $('#fields-config');
        this.$elementTypeSelector = $('#element-type-selector'); 
        this.attachmentType = fieldsConfig.data('attachment');
        this.$enumWrapper = $('#attribute-enums-wrapper');    
        this.$freeCounterBlock = $('#free-counter__block');
        this.$badgeBlock = $('#badge__block');
        this.$commentBlock = $('#comment-block');
        this.$elementTypeSelector.on('change',this.elementTypeSelectorChangeHandler.bind(this));       
        this.textType = fieldsConfig.data('text');
        this.htmlType = fieldsConfig.data('html');
        this.numberType = fieldsConfig.data('number');
        this.computedType = fieldsConfig.data('computed');
        this.requiredType = fieldsConfig.data('required');
        this.enumValues = fieldsConfig.data('enums'); 
        this.equipment = fieldsConfig.data('equipment');
        this.frieze = fieldsConfig.data('frieze');
        this.comment = fieldsConfig.data('comment');
        this.group = fieldsConfig.data('group');
        this.freeCounter = fieldsConfig.data('free_counter');
        this.badge = fieldsConfig.data('badge');
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

        if(this.enumValues.indexOf(value) !== -1) {
            this.$enumWrapper.removeClass('hide');
            $('#unit-price__container').hide();
        } else {
            this.$enumWrapper.addClass('hide');
            $('#unit-price__container').show();
        }
        (this.freeCounter.indexOf(value) !== -1) ?
            this.freeCountBlockShow(true) :
            this.freeCountBlockShow(false);
        (this.textType.indexOf(value) !== -1) ?
            this.textParamsShow(true) :
            this.textParamsShow(false);
        (this.htmlType.indexOf(value) !== -1) ?
            this.htmlParamsShow(true) :
            this.htmlParamsShow(false);  
        (this.attachmentType.indexOf(value) !== -1) ?
            this.attachmentParamsShow(true):
            this.attachmentParamsShow(false);
        (this.comment.indexOf(value) !== -1) ?
            this.commentShow(true) :
            this.commentShow(false);
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
        (this.badge == value) ?
            this.badgeParamShow(true):
            this.badgeParamShow(false);
        (this.group == value) ?
            this.groupParamShow(true):
            this.groupParamShow(false);
    }
    freeCountBlockShow(isShow) {
        isShow ?
            this.$freeCounterBlock.removeClass('hide'):
            this.$freeCounterBlock.addClass('hide');
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
    commentShow( isShow ) {
        isShow ? 
            this.$commentBlock.removeClass('hide') :
            this.$commentBlock.addClass('hide');
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
    badgeParamShow( isShow ) {
        isShow ? 
            this.$badgeBlock.removeClass('hide') :
            this.$badgeBlock.addClass('hide');
    }    
    groupParamShow( isShow ) {
        isShow ? 
            this.$groupBlock.removeClass('hide') :
            this.$groupBlock.addClass('hide');
    }    
}