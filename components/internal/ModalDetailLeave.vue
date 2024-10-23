<template>
  <div>
    <div class="left-0 fixed w-full min-h-screen z-30 bg-white c-form" :class="isDetailOpen ? 'c-detail--open': ''">
      <div class="py-4 px-8 flex justify-between border-b">
        <div class="font-extrabold text-lg w-full font-montserrat">Leave Request Detail</div>
        <img
          src="~/assets/images/cross.svg"
          class="mx-auto"
          alt="Close"
          width="32"
          height="32"
          @click="closeDetail()"
        />
      </div>
      <div class="py-4 px-8">
        <div class="grid grid-cols-1 gap-y-4 text-sm">
          <div>
            <div class="font-black font-montserrat">Leave Type</div>
            <div class="mt-2">Annual Leave</div>
          </div>
          <div>
            <div class="font-black font-montserrat">Leave Date Range</div>
            <div class="mt-2">10/10/2023 - 12/10/2023 (3 Days)</div>
          </div>
          <div>
            <div class="font-black font-montserrat">Status</div>
            <div class="mt-2">On Check</div>
            <div class="mt-1 text-2xs">(Last Updated Status at 10/10/2023)</div>
          </div>
          <div>
            <div class="font-black font-montserrat">Description</div>
            <div class="mt-2">Lorem ipsum dolor sit amet consectetur. Pellentesque pulvinar augue ligula in semper. Nisl sem risus est in ornare tellus at. Luctus senectus vel urna aliquet hendrerit enim eleifend sit. Lacus eget congue diam mauris pharetra. Faucibus sit consectetur tristique egestas consectetur lacus egestas. Semper dolor ut volutpat sagittis tincidunt orci augue sit. Venenatis pellentesque volutpat tempor eget erat. Lectus aliquam gravida malesuada maecenas. Bibendum quis nibh porttitor habitant eget vitae aliquam. Lacus vitae commodo nisl scelerisque ornare ullamcorper orci accumsan convallis. Lectus in ultricies tellus feugiat bibendum nunc ultrices bibendum hendrerit. Dignissim amet sed diam nisi. Placerat suscipit mauris id placerat malesuada ut lorem. Eu nulla sed ornare mi pulvinar nullam non bibendum augue. Enim sit non sapien vitae nulla fames dictumst. </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "AddAttendance",
  data() {
    return {
      data: [],
    }
  },
  props: {
    isDetailOpen: {
      type: Boolean,
      required: false,
    },
  },
  methods: {
    closeDetail() {
      this.$emit('close-detail');
    },
  }
};
</script>

<style>
  .c-detail {
    bottom: -100vh;
    transition: all 0.3s ease-in-out;
  }

  .c-detail--open {
    bottom: 0px;
  }
</style>