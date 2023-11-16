<template>
    <div>
        <h1 class="text-2xl font-bold">Admin</h1>
        <div class="flex gap-2 ">
            <button @click="createPolygon">Create Polygon </button>
            <button @click="savePolygon" v-if="polygon"> Save Polygon</button>
            <button @click="togglePolygonEdit" v-if="polygon && !editing">Edit
                Polygon</button>
            <button @click="togglePolygonEdit"
                v-if="polygon && editing">Done</button>
        </div>
        <div class="w-full h-[500px]">
            <MapComponent :markers="markers" :polygon="polygon" :drawing="drawing"
                :editable="editable" @map-clicked="addMarker"
                @polygon-updated="updatePolygon" @polygon-drawn="polygonDrawn" />
        </div>
        <div v-if="polygon"
            class="mt-4 text-blue-500 text-xs px-3 py-2 flex flex-col">
            <h2 class="text-xl font-bold">Polygon Coordinates:</h2>
            <ul class="text-md gap-2">
                <li v-for="(coord, index) in polygon" :key="index">
                    Latitude: {{ coord.lat }}, Longitude: {{ coord.lng }}
                </li>
            </ul>
        </div>
    </div>
</template>
  
<script>
import axios from 'axios';
import MapComponent from '../components/MapComponent.vue';

export default {
    components: {
        MapComponent
    },
    data() {
        return {
            markers: [],
            polygon: null,
            drawing: false,  //
            editable: false,
            editing: false,  // Add this line
        }
    },
    methods: {
        addMarker(event) {
            this.markers.push({ lat: event.latLng.lat(), lng: event.latLng.lng() });
            console.log("addMarker");
        },
        async polygonDrawn(polygon) {
            const google = await this.$gmapApiPromiseLazy();
            console.log(this.polygon.getPath().getArray());
            this.polygon = polygon.getPath().getArray().map(coord => ({
                lat: coord.lat(),
                lng: coord.lng()
            }));
            this.drawing = false;  // Set drawing to false

            let vueInstance = this;

            // Add event listeners for the set_at and insert_at events
            google.maps.event.addListener(polygon, 'set_at', function () {
                console.log('set_at event triggered');
                vueInstance.updatePolygon(polygon);
            });
            google.maps.event.addListener(polygon, 'insert_at', function () {
                console.log('insert_at event triggered');
                vueInstance.updatePolygon(polygon);
            });;
        },
        createPolygon() {
            this.drawing = true;  // Set drawing to true

            // this.polygon = null;
            // this.markers = [];
        },
        updatePolygon(polygon) {
            this.polygon = polygon.getPath().getArray().map(coord => ({
                lat: coord.lat(),
                lng: coord.lng()
            }));
            console.log(this.polygon);

        },
        togglePolygonEdit() {
            this.editable = !this.editable;
            this.editing = !this.editing;
        },
        async savePolygon() {
            try {
                // Convert the polygon vertices to the format expected by the API
                const boundary_coordinates = this.polygon.map(marker => ({
                    latitude: marker.lat,
                    longitude: marker.lng
                }));

                console.log(boundary_coordinates);

                const response = await axios.post('http://127.0.0.1:8000/api/save-serviceable-area', { boundary_coordinates });
                // Handle the response
                if (response.data.message) {
                    alert(response.data.message);  // Show a success message
                    // Clear the polygon data
                    this.polygon = null;
                }
            } catch (error) {
                console.error(error);
            }
        }
    }
}
</script>