<template>
  <div>
    <div class="left-0 fixed w-full min-h-screen z-30 bg-white c-form" :class="isAddForm ? 'c-form--open': ''">
      <div class="py-4 px-8 flex justify-between border-b">
        <div class="font-bold text-lg w-full">Create Leave Request</div>
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
        <div class="px-6">
          <div class="py-4 text-sm">
            <div class="text-xs text-primary-3 float-right mb-2">Leave balance before submitting</div>
            <div class="flex gap-2 w-full">
              <div class="bg-primary-4 p-2 rounded-lg w-1/3">
                <div class="flex items-center">
                  <span class="text-xs font-bold">Remaining</span>
                </div>
                <div class="text-2xl font-black mt-2">21</div>
                <div class="text-2xs mt-2 font-medium">
                  <div>11 Annual</div>
                  <div>10 Collective</div>
                  <div>2 Carry Over</div>
                </div>
              </div>
              <div class="bg-primary-4 p-2 rounded w-1/3">
                <div class="flex items-center">
                  <span class="text-xs font-bold">Used</span>
                </div>
                <div class="text-2xl font-black mt-2">2</div>
                <div class="text-2xs mt-2 font-medium">
                  <div>2 Annual</div>
                  <div>0 Collective</div>
                  <div>0 Carry Over</div>
                </div>
              </div>
              <div class="bg-primary-4 p-2 rounded w-1/3">
                <div class="flex items-center">
                  <span class="text-xs font-bold">Total</span>
                </div>
                <div class="text-2xl font-black mt-2">23</div>
                <div class="text-2xs mt-2 font-medium">
                  <div>13 Annual</div>
                  <div>10 Collective</div>
                  <div>2 Carry Over</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="py-4 px-8">
          <div class="text-primary-1">
            <div class="text-sm">Leave Type</div>
            <input
              v-model="data.date"
              type="text"
              placeholder="Select Date Range"
              name="date"
              class="w-full text-xs rounded-lg py-2 px-4 border-primary-3"
              required
            />
          </div>
          <div class="mt-5 text-primary-1">
            <div class="text-sm">Leave Date Range</div>
            <input
              v-model="data.date"
              type="text"
              placeholder="Select Date Range"
              name="date"
              class="w-full text-xs rounded-lg py-2 px-4 border-primary-3"
              required
            />
          </div>
          <div class="mt-5 text-primary-1">
            <div class="text-sm">Days Taken / Deducted</div>
            <input
              v-model="data.date"
              type="text"
              placeholder="Select Date Range First"
              name="date"
              class="w-full text-xs rounded-lg py-2 px-4 border-primary-3"
              required
            />
          </div>
          <div class="mt-5 text-primary-1">
            <div class="text-sm">Description</div>
            <textarea class="w-full text-xs rounded-lg py-2 px-4 border-primary-3" rows="8" placeholder="Type Leave Description"></textarea>
          </div>
          <div class="mt-2 text-primary-3 text-sm">
            Note : This request will be reviewed and determined by :<br><br>HRD -> Supervisor -> Sekjen / Deputy
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
  name: "AddLeaveRequest",
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