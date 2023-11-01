<template>
  <div class="min-h-screen bg-gray-100 flex flex-col">
    <header class="py-2 px-3 bg-blue-500 text-white">
      <nav class="flex justify-end gap-4 max-w-4xl mx-auto">
        <router-link class="text-lg hover:underline border-2 px-2 border-white"
          active-class="bg-white text-blue-500" to="/">Dashboard</router-link>
        <router-link class=" text-lg hover:underline border-2 px-2 border-white"
          active-class="bg-white text-blue-500" to="/admin">Admin</router-link>
      </nav>
    </header>

    <main class="flex-grow">
      <div class="max-w-4xl mx-auto py-6 px-4">
        <RouterView />
      </div>
    </main>
    <div>
      <h2>This is a heading test</h2>
    </div>
  </div>
</template>

<script setup>
import { RouterLink, RouterView } from 'vue-router'
</script>