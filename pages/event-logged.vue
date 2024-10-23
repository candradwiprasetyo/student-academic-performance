<template>
  <EventLoggedOld />
</template>

<script lang="ts" setup>
  definePageMeta({
    middleware: 'auth-event' // this should match the name of the file inside the middleware directory 
  })
</script>