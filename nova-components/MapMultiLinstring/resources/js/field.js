import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-map-multi-linstring', IndexField)
  app.component('detail-map-multi-linstring', DetailField)
  app.component('form-map-multi-linstring', FormField)
})
