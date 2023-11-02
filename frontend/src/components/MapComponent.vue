<template>
  <div class="w-full h-full">
    <GMapMap :center="center" :zoom="10" class="w-full h-full">
      <GMapPolygon :paths="paths" />
    </GMapMap>
  </div>
</template>


<script>

export default {
  name: 'App',
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
        fillColor: '#ff0000',
        fillOpacity: 0.6,
        strokeWeight: 1,
      }
    }
  },
}
</script>

<style scoped></style>