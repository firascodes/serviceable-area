<template>
  <h1 class="text-2xl font-bold mb-4">Dashboard</h1>

  <div class="flex h-[80vh] bg-gray-100">
    <div class="flex-1 overflow-hidden bg-white shadow">
      <MapComponent
        class="w-full h-full"
        :marker="marker"
        :polygon="boundary_coordinates"
        :center="center"
      />
    </div>
    <div class="p-8 px-10 space-y-4 overflow-auto bg-white shadow rounded-lg">
      <PlaceSearchInputComponent @place-selected="updateMarker" />
      <div class="text-center">
        <button
          class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-700"
          @click="checkServiceability"
          :disabled="isLoading"
        >
          Check Serviceability
          <span v-if="isLoading" class="loader"></span>
        </button>
        <p
          v-if="message"
          :class="{ 'bg-green-500': isServiceable, 'bg-red-500': !isServiceable }"
          class="mt-14 text-xl font-bold text-white py-4 rounded-full"
        >
          {{ message }}
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import MapComponent from '../components/MapComponent.vue'
import PlaceSearchInputComponent from '../components/PlaceSearchInputComponent.vue'

export default {
  name: 'DashboardView',
  components: {
    MapComponent,
    PlaceSearchInputComponent
  },
  data() {
    return {
      marker: null, // This will hold the marker coordinates
      boundary_coordinates: [], // This will hold the boundary coordinates
      center: { lat: 28.6139, lng: 77.209 },
      isLoading: false,
      isServiceable: false,
      message: ''
    }
  },
  methods: {
    updateMarker(coordinates) {
      this.marker = coordinates // Update the marker when a place is selected
    },
    checkServiceability() {
      this.isLoading = true

      const { marker } = this

      //   console.log(marker.lat) // logs the latitude
      //   console.log(marker.lng) // logs the longitude

      this.isLoading = false

      axios
        .post('http://127.0.0.1:8000/api/check-coordinates', {
          latitude: marker.lat,
          longitude: marker.lng
        })
        .then((response) => {
          this.isServiceable = response.data.is_serviceable
          this.message = this.isServiceable ? 'Area is serviceable' : 'Area is not serviceable'
        })
        .catch((error) => {
          this.message = 'An error occurred'
        })
        .finally(() => {
          this.isLoading = false
        })
    }
  },
  async created() {
    // Fetch the coordinates from the API when the component is created
    const response = await axios.get('http://127.0.0.1:8000/api/serviceable-area')
    console.log(response.data)
    this.boundary_coordinates = response.data

    // Transform the boundary_coordinates array into an array of objects with numeric lat and lng properties
    this.boundary_coordinates = this.boundary_coordinates.map((coordinate) => ({
      lat: Number(coordinate.latitude),
      lng: Number(coordinate.longitude)
    }))
    // Calculate the centroid of the polygon and set it as the center of the map
    let totalLat = 0
    let totalLng = 0
    for (let i = 0; i < this.boundary_coordinates.length; i++) {
      totalLat += this.boundary_coordinates[i].lat
      totalLng += this.boundary_coordinates[i].lng
    }
    this.center = {
      lat: totalLat / this.boundary_coordinates.length,
      lng: totalLng / this.boundary_coordinates.length
    }
  }
}
</script>

<style scoped></style>
