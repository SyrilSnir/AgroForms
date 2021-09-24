import axios from 'axios';
import FieldParams from './components/manage/FieldParams';
import EnumList from './components/manage/EnumList';

const $ = window.$;
const managerActivateLink = document.getElementById('get-activare-link');
const getFormRequestButton = document.getElementById('get-form-request');
const fieldsConfig = document.getElementById('fields-config');

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
          //  alert (response.data);
        });  
}

function getFormRequestHandler(e) {
    const selectedOption = document.querySelector('[name="requests-list"] option:checked');
    let selectedValue = selectedOption.value;
    location.href = '/panel/member/requests/create?id=' + selectedValue;
}
