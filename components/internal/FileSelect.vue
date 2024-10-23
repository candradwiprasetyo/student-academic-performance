<template>
  <label class="file-select">
    <div class="select-button text-center w-full py-2 text-white font-bold rounded-lg bg-green-2 px-3 text-sm">
      <span>Find File</span>
    </div>
    <input type="file" @change="handleFileChange"/>
    <input type="file" @change="clearFile"/>
  </label>
</template>

<script>
export default {
  props: {
    value: File
  },

  methods: {
    handleFileChange(e) {
      this.$emit('input', e.target.files[0])
    },
    clearFile() {
      this.$emit('input', null)
    }
  }
}
</script>
