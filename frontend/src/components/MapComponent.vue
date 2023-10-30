<template>
  <div class="w-full h-full">
    <GMapMap :center="center" :zoom="4" class="w-full h-full">
      <GMapPolygon :paths="paths" />
    </GMapMap>
  </div>
</template>


<script>
export default {
  name: 'App',
  data() {
    return {
      center: { lat: 25.774, lng: -80.19 },
      paths: [
        { lat: 25.774, lng: -80.19 },
        { lat: 18.466, lng: -66.118 },
        { lat: 32.321, lng: -64.757 },
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