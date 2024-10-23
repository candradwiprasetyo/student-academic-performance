<template>
  <div>
    <div class="fixed inset-0 z-20 bg-black opacity-75"></div>
    <div class="fixed inset-0 z-30 flex items-center">
      <div class="mx-auto bg-white w-full md:w-[480px] md:rounded-lg h-screen md:h-auto relative p-4">
        <div class="text-xl font-extrabold font-montserrat text-green-2">{{ title  }}</div>
        <div class="mt-2 text-base mb-4">{{ message }}</div>
        <table class="text-xs" v-if="type==='popup-delete-event'">
          <tr class="py-2">
            <td><strong>Event Name</strong></td>
            <td>:</td>
            <td>{{ eventName }}</td>
          </tr>
          <tr class="py-2">
            <td><strong>Event Time</strong></td>
            <td>:</td>
            <td>{{ eventTime }}</td>
          </tr>
        </table>
        <div class="flex justify-between mt-4">
          <div class="bg-green-2 text-white text-sm font-bold px-4 py-2 rounded-lg inline-block cursor-pointer" @click="closePopup()">Close</div>
          <div class="text-white text-sm font-bold bg-red-2 py-2 px-4 rounded-lg inline-block cursor-pointer" @click="action()" v-if="buttonText">{{ buttonText }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "AdminPopup",
  props: {
    title: {
      type: String,
      required: false,
    },
    message: {
      type: String,
      required: false,
    },
    type: {
      type: String,
      required: false,
    },
    buttonText: {
      type: String,
      required: false,
    },
    eventName: {
      type: String,
      required: false,
    },
    eventTime: {
      type: String,
      required: false,
    },
  },
  methods: {
    closePopup() {
      this.$emit('close-popup');
    },
    action() {
      this.$emit('action');
    }
  }
};
</script>