<template>
  <div>
    <div class="fixed inset-0 z-30 bg-black opacity-50" v-if="isModalCheckoutOpen"></div>
    <div class="fixed w-full z-30 bg-white c-modal" :class="isModalCheckoutOpen ? 'c-modal--open': ''">
      <div class="p-8 text-center">
        <div class="font-bold text-lg w-full">Check Out Today Attendances</div>
        <div class="mt-2 text-sm">10/10/2023 18:11:59</div>
        <button
          class=" text-center w-full py-3 text-green-2 font-bold rounded-lg bg-green-4 mt-8 border-green-2"
          @click="closeModalCheckout()"
        >
          Close
        </button>
        <button
          class=" text-center w-full py-3 text-white font-bold rounded-lg bg-red-2 mt-4"
          @click="checkOut()"
        >
          Check out for Today
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ModalCheckout",
  data() {
    return {}
  },
  props: {
    isModalCheckoutOpen: {
      type: Boolean,
      required: false,
    },
  },
  methods: {
    closeModalCheckout() {
      this.$emit('close-modal-checkout');
    },
    checkOut() {
      this.$emit('check-out');
      this.$emit('close-modal-checkout');
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