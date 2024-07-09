import axios from 'axios';
import FieldParams from './components/manage/FieldParams';
import EnumList from './components/manage/EnumList';
import FormManager from './components/manage/Requests/FormManager';

const $ = window.$;
const managerActivateLink = document.getElementById('get-activare-link');
const getFormRequestButton = document.getElementById('get-form-request');
const fieldsConfig = document.getElementById('fields-config');
const modalRequestInfo = document.getElementById('modal-request__information');
const ruleCreateLink = document.getElementById('create-new-rule');

if (fieldsConfig) {
    const fieldParams = new FieldParams(); 
    const enumList = new EnumList('#attributes-enum-list');
    enumList.init();    
}

if (managerActivateLink) {
    managerActivateLink.addEventListener('click', managerActivateHandler);
}

if (getFormRequestButton) {
    getFormRequestButton.addEventListener('click', getFormRequestHandler);
}

if (modalRequestInfo) {
    $(modalRequestInfo).on('show.bs.modal',(e) => {
        let modalRequestContent = $('#modal-request__content');        
        let requestId = $(e.relatedTarget).data('request');
        modalRequestContent.html('');
        $.get('/panel/member/requests/get-reject-info',{
            id: requestId
        },(data) => {
            modalRequestContent.html(data);
        })
    });
}

if (ruleCreateLink) {
    ruleCreateLink.addEventListener('click', createLinkHandler);
}

function managerActivateHandler(e) {
    const userId = e.target.getAttribute('data-user');
    axios.get('/api/user/get-activate-link', 
        {
            params: {
                id : userId
            }
        })
        .then(response => {
            const link = response.data;
            $('#activate-link').html(link).attr('href',link);
            $('#show-activate-link').modal();
        });  
}

function getFormRequestHandler(e) {
    const selectedOption = document.querySelector('[name="requests-list"] option:checked');
    let selectedValue = selectedOption.value;
    let contractId = getFormRequestButton.dataset.contract;
    location.href = '/panel/member/requests/create?formId=' + selectedValue + '&contractId=' + contractId;
}

function createLinkHandler(e) {
    e.preventDefault();
    const link = e.currentTarget;
    console.log(link);
    const formSelector = document.getElementById('frm-id');
    const exSelector = document.getElementById('ex-id');
    const formId = formSelector.value;
    const exId = exSelector.value;
    const roleId = link.dataset.role;
    console.log('Select', formId,exId);
    let queryString = `?roleId=${roleId}`;
    if (formId) {
        queryString += `&formId=${formId}`;
    } else if (exId) {
        queryString += `&exhibitionId=${exId}`;
    }
    location.href = link.href + queryString;
}

const formManager = new FormManager();
