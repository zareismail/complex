Nova.booting((Vue, router, store) => {
  Vue.component('index-complex', require('./components/IndexField'))
  Vue.component('detail-complex', require('./components/DetailField'))
  Vue.component('form-complex', require('./components/FormField'))
})
