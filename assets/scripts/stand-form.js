import StandApp from './components/vue/Stand/StandApp';
const Vue = window.Vue;
const isReadOnly = !!document.getElementById('stand-app').getAttribute('data-read_only');
/*
(function() {
    console.log('Stand Form loading!!!');
})(window.Vue)
*/
Vue.filter('formatPrice',function(price) {
    let val = price.toString().replace(/[^0-9]/g, '');
    val = val.replace(/^0/, '');
    if (val == '') {
        val = '0';
    }
    val = val.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1 ');        

    return val + ' USD';
}
)
new Vue({
  el: '#stand-app',
  render: h => h(StandApp, {
    props: {
        isReadOnly
      }      
  })
})

//console.log(Vue);
