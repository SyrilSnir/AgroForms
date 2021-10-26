import DynamicFormApp from './components/vue/DynamicForm/DynamicFormApp.vue';
const Vue = window.Vue;
const isReadOnly = !!document.getElementById('dynamic-form-app').getAttribute('data-read_only');
console.log('read only=' + isReadOnly);
new Vue({
    el: '#dynamic-form-app',
    render: h => h(DynamicFormApp,{
      props: {
        isReadOnly
      }
    })
  })