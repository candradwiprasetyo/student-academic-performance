<template>
  <div>
    <div class="fixed inset-0 z-30 bg-black opacity-50" v-if="isModalCheckinOpen"></div>
    <div class="fixed w-full z-30 bg-white c-modal" :class="isModalCheckinOpen ? 'c-modal--open': ''">
      <div class="py-4 px-8 flex justify-between border-b">
        <div class="font-bold text-lg w-full">Check in for today</div>
        <img
          src="~/assets/images/cross.svg"
          class="mx-auto"
          alt="Close"
          width="32"
          height="32"
          @click="closeModalCheckin()"
        />
      </div>
      <div class="py-4 px-8">
        <textarea class="w-full h-40 outline-none" placeholder="Write down the description of your check in, starting from the check-in location, the reason for the delay if late or if there’s nothing to explain, you can just leave it blank."></textarea>
      </div>
      <div class="py-4 px-8">
        <button
          class=" text-center w-full py-3 text-white font-bold rounded-lg bg-green-2"
          @click="checkIn()"
        >
          Submit and Check in
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ModalCheckin",
  data() {
    return {}
  },
  props: {
    isModalCheckinOpen: {
      type: Boolean,
      required: false,
    },
  },
  methods: {
    closeModalCheckin() {
      this.$emit('close-modal-checkin');
    },
    checkIn() {
      this.$emit('check-in');
      this.$emit('close-modal-checkin');
    },
  }
};
</script>

<style>
  .c-modal {
    bottom: -500px;
    transition: all 0.3s ease-in-out;
  }

  .c-modal--open {
    bottom: 0;
  }
</style>