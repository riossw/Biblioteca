<template>
  <div class="p-10 text-center">
    <h1 class="text-4xl font-bold text-blue-600">¡Hola {{ nombre }}!</h1>
    <p class="mt-4 text-gray-600">{{ mensaje }}</p>
  </div>
</template>

<script setup>
defineProps({
  nombre: String,
  mensaje: String,
})
</script>
