const $ = window.$;
export default class FormManager {
    constructor() {
        this.$form = $('#status-change-form');
        this.$formButtons = this.$form.find('.status-change-btn');
        this.$statusInput = $('#changestatusform-status');
        this.$formButtons.on('click',this.changeStatus.bind(this));
    }
    changeStatus(e) {
        let status = $(e.target).data('status');
        this.$statusInput.val(status);
        this.$form.submit();
    }
}