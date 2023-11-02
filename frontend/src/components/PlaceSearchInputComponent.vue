<template>
    <div>
        <h1 class="mb-2 text-blue-500 font-bold text-center">Search for a Place</h1>
        <div class="border px-2 py-2">
            <Autocomplete ref="autocomplete" v-on:place_changed="getPlaceData"
                placeholder="Enter a location" class="px-8 py-1 w-full" />
        </div>
        <div v-if="coordinates"
            class="mt-4 text-blue-500 text-xs px-3 py-2 flex flex-col">
            <div class="inline-flex gap-2">
                <p class="font-bold">Latitude - </p>{{ coordinates.lat }}
            </div>
            <div class="inline-flex gap-2">
                <p class="font-bold">Longitude - </p> {{ coordinates.lng }}
            </div>
        </div>
    </div>
</template>
  
<script>
import { Autocomplete } from '@fawmi/vue-google-maps'

export default {
    name: 'PlaceSearchInputComponent',
    components: {
        Autocomplete
    },
    data() {
        return {
            coordinates: null
        }
    },
    methods: {
        getPlaceData(place) {
            this.coordinates = {
                lat: place.geometry.location.lat(),
                lng: place.geometry.location.lng()
            };
            console.log(this.coordinates);
            // The coordinates data property is now updated with the new coordinates
            this.$emit('place-selected', this.coordinates);
        }
    }
}
</script>


