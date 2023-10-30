<template>
    <div class="flex h-[80vh] bg-gray-100">
        <div class="flex-1 overflow-hidden bg-white shadow rounded-lg">
            <MapComponent class="w-full h-full" />
        </div>
        <div class="p-8 px-10 space-y-4 overflow-auto bg-white shadow rounded-lg">
            <h1 class="text-2xl font-bold">Dashboard</h1>
            <PlaceSearchInputComponent />
            <button
                class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-700">
                Check Serviceability
            </button>
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
    }
}
</script>

<style scoped></style>