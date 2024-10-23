<template>
  <div>
    <div class="fixed inset-0 z-30 bg-black opacity-75"></div>
    <div class="fixed inset-0 z-30 flex items-center">
      <div class="mx-auto bg-white w-full md:w-[480px] md:rounded-lg h-screen md:h-auto relative">
        <div class="h-16 block md:hidden w-full bg-white z-50 border-b-2 border-gray-300">
          <img
            src="~/assets/images/close.svg"
            class="float-right cursor-pointer top-4 right-4 absolute"
            alt="close"
            @click="closePopup()"
          />
        </div>
        <div class="px-4 md:px-6 mx-auto text-left md:w-600 relative font-medium mt-4 md:mt-6 pb-6">
          <div class="absolute -top-12 md:top-0 right-4 hidden md:inline">
            <img
              src="~/assets/images/close.svg"
              class="float-right cursor-pointer z-50"
              alt="close"
              @click="closePopup()"
            />
          </div>
          <div class="text-xl font-extrabold capitalize font-montserrat text-green-2 md:mt-0 mt-4 w-11/12">
            Enter Keyword to Unlock Rundown
          </div>
          <div class="my-4 bg-red-2 text-white text-center text-xs font-bold rounded py-2" v-if="isKeywordWrong">Wrong keyword</div>
          <div class="mt-2 md:mt-5 text-primary-1">
            <div class="text-sm">Rundown Keyword</div>
            <input type="password" class="w-full text-xs rounded-lg py-2 px-4 border-primary-3" placeholder="Enter keyword here" v-model="keyword" />
          </div>
          <div class="mt-6">
            <button class="bg-green-2 text-center w-full py-3 text-white font-bold rounded-lg" @click="openRundown()">Enter Event</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "PopupLocked",
  props: {
    title: {
      type: String,
      required: false,
    },
    message: {
      type: String,
      required: false,
    },
    isKeywordWrong: {
      type: Boolean,
      required: false,
    },
  },
  data() {
    return {
      keyword: '',
    }
  },
  methods: {
    closePopup() {
      this.$emit('close-popup');
    },
    openRundown() {
      this.$emit('open-rundown', this.keyword);
    }
  }
};
</script>