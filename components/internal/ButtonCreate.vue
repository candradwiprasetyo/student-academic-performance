<template>
  <div>
    <div class="bottom-4 right-8 fixed w-16 h-16 z-30 bg-green-2 text-white text-center flex justify-center items-center rounded rounded-2xl text-3xl font-medium" @click="createData()">
      +
    </div>
  </div>
</template>

<script>
export default {
  name: "ButtonCreate",
  data() {
    return {}
  },
  methods: {
    createData() {
      this.$emit('create-data');
    },
  }
};
</script>