import DynamicFormApp from './components/vue/DynamicForm/DynamicFormApp';
const Vue = window.Vue;

new Vue({
    el: '#dynamic-form-app',
    render: h => h(DynamicFormApp)
  })