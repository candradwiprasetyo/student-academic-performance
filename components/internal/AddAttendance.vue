<template>
  <div>
    <div class="left-0 fixed w-full min-h-screen z-30 bg-white c-form" :class="isAddForm ? 'c-form--open': ''">
      <div class="py-4 px-8 flex justify-between border-b">
        <div class="font-bold text-lg w-full">Attendance Request</div>
        <img
          src="~/assets/images/cross.svg"
          class="mx-auto"
          alt="Close"
          width="32"
          height="32"
          @click="closeForm()"
        />
      </div>
      <div class="overflow-auto h-[calc(100vh-62px)] pb-40">
        <div class="py-4 px-8">
          <div class="text-primary-1">
            <div class="text-sm">Date</div>
            <input
              v-model="data.date"
              type="text"
              placeholder="Select Attendance Date"
              name="date"
              class="w-full text-xs rounded-lg py-2 px-4 border-primary-3"
              required
            />
          </div>
          <div class="mt-5 text-primary-1">
            <div class="text-sm">Check In</div>
            <input
              v-model="data.date"
              type="text"
              placeholder="Select Check In Time"
              name="date"
              class="w-full text-xs rounded-lg py-2 px-4 border-primary-3"
              required
            />
          </div>
          <div class="mt-5 text-primary-1">
            <div class="text-sm">Check Out</div>
            <input
              v-model="data.date"
              type="text"
              placeholder="Select Check Out Time"
              name="date"
              class="w-full text-xs rounded-lg py-2 px-4 border-primary-3"
              required
            />
          </div>
          <div class="mt-5 text-primary-1">
            <div class="text-sm">Attendance Request Description</div>
            <textarea class="w-full text-xs rounded-lg py-2 px-4 border-primary-3" rows="8" placeholder="Type your request description"></textarea>
          </div>
          <div class="mt-5">
            <div class="text-sm">Upload Supported File</div>
            <div class="flex gap-2">
              <div class="flex-grow">
                <div :class="file?.name ? '' : 'text-primary-3'" class="w-full text-xs rounded-lg py-2 px-4 border-primary-3">{{ (file?.name) ? file?.name : 'Upload Supported File'}}</div>
              </div>
              <div class="flex-none"><p><InternalFileSelect v-bind:value="file" @input="file = $event"></InternalFileSelect></p></div>
            </div>
            <div class="text-xs">Max Size : 1 Mb - Supported : PDF/JPG/PNG</div>
          </div>
          <div class="mt-2 text-primary-3 text-sm">
            Note : This request will be reviewed and determined with the following flow : <br><br> HRD -> Approved <br><br> Contact according to approval position for questions or further explanation.
          </div>
        </div>
      </div>
      <div class="absolute w-full p-4 bottom-0 border-t-2">
        <button 
          class="text-center py-3 text-white font-bold rounded-lg bg-green-2 float-right px-4"
        >
          Submit
        </button>
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
      file: null,
    }
  },
  props: {
    isAddForm: {
      type: Boolean,
      required: false,
    },
  },
  methods: {
    closeForm() {
      this.$emit('close-form');
    },
  }
};
</script>

<style>
  .c-form {
    bottom: -100vh;
    transition: all 0.3s ease-in-out;
  }

  .c-form--open {
    bottom: 0px;
  }
</style>