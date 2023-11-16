<template>
  <div class="w-full h-full">
    <GMapMap :center="center" :zoom="10" class="w-full h-full" ref="gmap">
      <GMapMarker v-for="(marker, index) in markers" :key="index"
        :position="marker" :icon='{
          url: "https://upload.wikimedia.org/wikipedia/commons/thumb/8/88/Map_marker.svg/640px-Map_marker.svg.png",
          scaledSize: { width: 35, height: 50 },
          // labelOrigin: {x: 16, y: -10}
        }' />
      <GMapPolygon v-if="polygon && polygon.length" :paths="polygon"
        :options="options" :editable="editable" />
    </GMapMap>
  </div>
</template>

<script>

export default {
  name: 'MapComponent',
  props: ['markers', 'polygon', 'drawing', 'editable'],
  data() {
    return {
      center: { lat: 28.6139, lng: 77.2090 },
      curentPolygon: null,
      drawingManager: null,
      options: {
        fillColor: "#93C5FD",
        fillOpacity: 0.6,
        strokeWeight: 2,
        clickable: false,
        zIndex: 1,
      },
    }
  },

  methods: {
    async drawPolygon() {
      const map = await this.$refs.gmap.$mapObject;
      const google = await this.$gmapApiPromiseLazy();
      if (this.drawingManager) {
        this.drawingManager.setMap(null);
      }
      this.drawingManager = new google.maps.drawing.DrawingManager({
        drawingMode: google.maps.drawing.OverlayType.POLYGON,
        drawingControl: true,
        drawingControlOptions: {
          position: google.maps.ControlPosition.TOP_CENTER,
          drawingModes: [
            google.maps.drawing.OverlayType.POLYGON
          ]
        },
      });
      this.drawingManager.setMap(map);
      google.maps.event.addListener(this.drawingManager, 'overlaycomplete', (event) => {
        if (event.type == google.maps.drawing.OverlayType.POLYGON) {
          if (this.currentPolygon) {
            this.currentPolygon.setMap(null);
          }

          // Keep a reference to the current polygon
          this.currentPolygon = event.overlay;

          this.$emit('polygon-drawn', event.overlay);
          this.drawingManager.setMap(null);
        }
        // const polygon = event.overlay.getPath().getArray().map(coord => ({
        // lat: coord.lat(),
        //   lng: coord.lng()
        // }));
      });
    }
  },
  watch: {
    'drawing': function (newVal, oldVal) {
      if (newVal !== oldVal && newVal === true) {
        this.drawPolygon();
      }
    }
  },
  mounted() {
    this.drawPolygon();
  }

}
</script>

<style scoped></style>

<!-- data() {
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
  }, -->