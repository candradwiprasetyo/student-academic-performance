<template>
  <div>
    <div class="fixed inset-0 z-30 bg-black opacity-75"></div>
    <div class="fixed inset-0 z-30 flex items-center">
      <div class="mx-auto bg-white w-full md:w-[600px] md:rounded-lg h-screen md:h-auto md:px-2 md:pb-4">
        <div class="max-h-screen md:max-h-[90vh] overflow-auto relative">
          <div class="h-16 inline md:hidden w-full fixed bg-white z-50 border-b-2 border-gray-300">
            <img
              src="~/assets/images/close.svg"
              class="float-right cursor-pointer top-4 right-4 absolute"
              alt="close"
              @click="closePopup()"
            />
          </div>
          <div class="h-16 block md:hidden w-full"></div>
          <div class="md:px-4 mx-auto text-left md:w-600 relative font-medium">
            <div class="absolute top-3 right-4 hidden md:inline">
              <img
                src="~/assets/images/close.svg"
                class="float-right cursor-pointer"
                alt="close"
                @click="closePopup()"
              />
            </div>
            <img
              :src="urlImg"
              class="inline-block mt-14 rounded-xl hidden md:inline "
              alt="Event detail"
            />
            <img
              :src="urlImg"
              class="inline-block inline md:hidden "
              alt="Event detail"
            />
          </div>
          <div class="px-4 pb-4 mx-auto text-left md:w-600 relative font-medium">
            <div class="mt-4 text-xl font-extrabold capitalize font-montserrat text-green-2">
              {{ title }}
            </div>
            <div class="my-4 text-xs text-green-1 gap-2">
              <span>{{ date  }}</span>
              <span class="px-2">&#x2022;</span>
              <span>{{ time  }}</span>
              <span class="px-2">&#x2022;</span>
              <span>{{ location  }}</span>
            </div>
            <div class="text-sm text-primary-1 pb-4" v-html="message">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "PopupEvent",
  props: {
    title: {
      type: String,
      required: false,
    },
    message: {
      type: String,
      required: false,
    },
    date: {
      type: String,
      required: false,
    },
    time: {
      type: String,
      required: false,
    },
    location: {
      type: String,
      required: false,
    },
    urlImg: {
      type: String,
      required: false,
    }
  },
  methods: {
    closePopup() {
      this.$emit('close-popup');
    }
  }
};
</script>