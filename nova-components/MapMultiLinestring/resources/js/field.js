import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'
import MapComponent from './components/MapComponent'

Nova.booting((app, store) => {
  app.component('wm-map-multi-linestring', MapComponent)
  app.component('index-map-multi-linestring', IndexField)
  app.component('detail-map-multi-linestring', DetailField)
  app.component('form-map-multi-linestring', FormField)
})
