<template>
  <div>
    <div class="fixed inset-0 z-20 bg-black opacity-75"></div>
    <div class="fixed inset-0 z-30 flex items-center">
      <div class="mx-auto bg-white w-full md:w-[480px] md:rounded-lg h-screen md:h-auto relative p-4">
        <div class="text-xl font-extrabold font-montserrat text-green-2">Delete Event Confirmation</div>
        <div class="mt-2 text-xs mb-4">Are you sure you want to delete this event ? </div>
        <table class="text-xs">
          <tr class="py-2">
            <td><strong>Event Name</strong></td>
            <td>:</td>
            <td>Gathering</td>
          </tr>
          <tr class="py-2">
            <td><strong>Event Time</strong></td>
            <td>:</td>
            <td>31/10/2023 08:00 - 12:00</td>
          </tr>
        </table>
        <div class="flex justify-between mt-4">
          <div class="text-green-2 text-sm font-bold py-2 px-4 rounded-lg inline-block cursor-pointer" @click="closePopup()">Back</div>
          <div class="text-white text-sm font-bold bg-red-2 py-2 px-4 rounded-lg inline-block cursor-pointer" @click="closePopup()">Delete Event</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "AdminPopupDeleteEvent",
  props: {
    title: {
      type: String,
      required: false,
    },
    message: {
      type: String,
      required: false,
    },
  },
  methods: {
    closePopup() {
      this.$emit('close-popup');
    },
    openRundown() {
      this.$emit('open-rundown');
    }
  }
};
</script>