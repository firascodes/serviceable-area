<template>
  <div class="w-full h-full">
    <GMapMap :center="center" :zoom="10" class="w-full h-full">
      <GMapMarker v-for="(marker, index) in markers" :key="index"
        :position="marker" :icon='{
          url: "https://upload.wikimedia.org/wikipedia/commons/thumb/8/88/Map_marker.svg/640px-Map_marker.svg.png",
          scaledSize: { width: 35, height: 50 },
          // labelOrigin: {x: 16, y: -10}
        }' />
      <GMapPolygon v-if="polygon && polygon.length" :paths="polygon"
        :options="options" />
    </GMapMap>
  </div>
</template>


<script>

export default {
  name: 'MapComponent',
  data() {
    return {
      center: { lat: 28.6139, lng: 77.2090 },
      paths: [
        { lat: 28.5139, lng: 77.1090 },
        { lat: 28.7139, lng: 77.1090 },
        { lat: 28.7139, lng: 77.3090 },
        { lat: 28.5139, lng: 77.3090 },
      ],
      options: {
        strokeColor: "#3B82F6", // Tailwind's blue-500
        strokeOpacity: 0.8,
        strokeWeight: 3,
        fillColor: "#93C5FD", // Tailwind's blue-300
        fillOpacity: 0.35,
      }
    }
  },
  props: {
    markers: Array,
    polygon: Array
  },
}
</script>

<style scoped></style>