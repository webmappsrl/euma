
<template>
    <div id="container">
        <div :id="mapRef" class="wm-map"></div>
    </div>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'
import "leaflet/dist/leaflet.css";
import L from "leaflet";
const DEFAULT_TILES = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
const DEFAULT_ATTRIBUTION = '<a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery (c) <a href="https://www.mapbox.com/">Mapbox</a>';
const DEFAULT_CENTER = [0, 0];
const DEFAULT_MINZOOM = 8;
const DEFAULT_MAXZOOM = 17;
const DEFAULT_DEFAULTZOOM = 8;
const linestringOption = {
    fillColor: '#f03',
    fillOpacity: 0.5,
};
let mapDiv = null;
let linestring = null;
export default {
    name: "MapMultiLineString",
    mixins: [FormField, HandlesValidationErrors],
    props: ['field', 'geojson'],
    data() {
        return {
            mapRef: `mapContainer-${Math.floor(Math.random() * 10000 + 10)}`,
            uploadFileContainer: 'uploadFileContainer',
        }
    },
    methods: {
        initMap() {
            setTimeout(() => {
                const center = this.field.center ?? this.center ?? DEFAULT_CENTER;
                const defaultZoom = this.field.defaultZoom ?? DEFAULT_DEFAULTZOOM;
                const linestringGeojson = this.field.geojson;
                mapDiv = L.map(this.mapRef).setView(center, defaultZoom);

                L.tileLayer(
                    this.field.tiles ?? DEFAULT_TILES,
                    {
                        attribution: this.field.attribution ?? DEFAULT_ATTRIBUTION,
                        maxZoom: this.field.maxZoom ?? DEFAULT_MAXZOOM,
                        minZoom: this.field.minZoom ?? DEFAULT_MINZOOM,
                        id: "mapbox/streets-v11",
                    }
                ).addTo(mapDiv);

                if (linestringGeojson != null) {
                    linestring = L.geoJson(JSON.parse(linestringGeojson), {
                        style: linestringOption
                    }).addTo(mapDiv);
                    mapDiv.fitBounds(linestring.getBounds());
                }

                mapDiv.dragging.disable();
                mapDiv.zoomControl.remove()
                mapDiv.scrollWheelZoom.disable();
                mapDiv.doubleClickZoom.disable();
            }, 300);
        }
    },
    watch: {
        geojson: (gjson) => {
            if (linestring != null) {
                mapDiv.removeLayer(linestring);
            }
            if (gjson != null) {
                linestring = L.geoJSON(gjson, linestringOption).addTo(mapDiv);
                mapDiv.fitBounds(linestring.getBounds());
            }
        }
    },
    mounted() {
        this.initMap();
    },
};
</script>
