<template>
  <PanelItem :index="index" :field="field">
    <template #value>
      <wm-map-multi-linestring :field="field"></wm-map-multi-linestring>
    </template>
  </PanelItem>
</template>

<script>
export default {
  props: ['index', 'field'],
}
</script>
