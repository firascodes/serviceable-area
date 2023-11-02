<template>
    <h1 class="text-2xl font-bold mb-4">Dashboard</h1>

    <div class="flex h-[80vh] bg-gray-100">
        <div class="flex-1 overflow-hidden bg-white shadow ">
            <MapComponent class="w-full h-full" :marker="marker" />
        </div>
        <div class="p-8 px-10 space-y-4 overflow-auto bg-white shadow rounded-lg">
            <PlaceSearchInputComponent @place-selected="updateMarker" />
            <div class="text-center">
                <button
                    class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-700">
                    Check Serviceability
                </button>
            </div>
        </div>
    </div>
</template>
  
<script>
import MapComponent from '../components/MapComponent.vue'
import PlaceSearchInputComponent from '../components/PlaceSearchInputComponent.vue'

export default {
    name: 'DashboardView',
    components: {
        MapComponent,
        PlaceSearchInputComponent,
    },
    data() {
        return {
            marker: null // This will hold the marker coordinates
        }
    },
    methods: {
        updateMarker(coordinates) {
            this.marker = coordinates; // Update the marker when a place is selected
        }
    }
}
</script>

<style scoped></style>