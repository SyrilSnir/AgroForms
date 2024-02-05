import DynamicFormApp from './components/vue/DynamicForm/DynamicFormApp.vue';
const Vue = window.Vue;
Vue.config.devtools = false;
const appRootElement = document.getElementById('dynamic-form-app');
const isReadOnly = !!appRootElement.dataset.readOnly;
const contractId = parseInt(appRootElement.dataset.contractId);
console.log('read only=' + isReadOnly);
new Vue({
    el: '#dynamic-form-app',
    render: h => h(DynamicFormApp,{
      props: {
        isReadOnly, contractId
      }
    })
  })