<template>
    <div>
        <h1 class="text-2xl font-bold">Admin</h1>
        <div class="flex gap-2 ">
            <button @click="createPolygon">Create Polygon </button>
            <button @click="savePolygon" v-if="polygon"> Save Polygon</button>
        </div>
        <div class="w-full h-[500px]">
            <MapComponent :markers="markers" :polygon="polygon"
                @map-clicked="addMarker" />
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
            polygon: null
        }
    },
    methods: {
        addMarker(event) {
            this.markers.push({ lat: event.latLng.lat(), lng: event.latLng.lng() });
            console.log("addMarker");
        },
        createPolygon() {
            this.polygon = this.markers;
            this.markers = [];
        },
        async savePolygon() {
            try {
                // Convert the polygon vertices to the format expected by the API
                const boundary_coordinates = this.polygon.map(marker => ({
                    latitude: marker.lat,
                    longitude: marker.lng
                }));

                console.log(boundary_coordinates);

                const response = await axios.post('http://localhost:8000/api/save-serviceable-area', { boundary_coordinates });
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