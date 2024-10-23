<template>
  <div>
    <div class="left-0 fixed w-full min-h-screen z-30 bg-white c-form" :class="isAddForm ? 'c-form--open': ''">
      <div class="py-4 px-8 flex justify-between border-b">
        <div class="font-bold text-lg w-full">Create New Reimbursement</div>
        <img
          src="~/assets/images/cross.svg"
          class="mx-auto"
          alt="Close"
          width="32"
          height="32"
          @click="closeForm()"
        />
      </div>
      <div class="px-8 py-4 gap-2 text-sm flex border-b-2 border-dashed pb-6">
        <div class="flex-1">
          <div class="mb-1">Select Period Month</div>
          <select class="py-2 px-3 rounded-lg border-2 w-full">
            <option value="1">January</option>
            <option value="2">February</option>
            <option value="3">March</option>
            <option value="4">April</option>
            <option value="5">May</option>
            <option value="6">June</option>
            <option value="7">July</option>
            <option value="8">August</option>
            <option value="9">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
          </select>
        </div>
        <div class="flex-1">
          <div class="mb-1">Select Period Year</div>
          <select class="py-2 px-3 rounded-lg border-2 w-full">
            <option value="1">2023</option>
            <option value="2">2024</option>
          </select>
        </div>
      </div>
      <div class="">
        <div class="py-4 px-8">
          <div class="flex justify-end">
            <div 
              class="text-center py-2 text-white font-bold rounded-lg bg-green-2 px-4 border-green-2 text-sm"
              @click="triggerFormItem"
            >
              Add New Item
            </div>
          </div>
          <div class="mt-2 text-primary-3 text-sm">
            No item added<br><br> Note : This request will be reviewed and determined with the following flow :
            <br><br>
            HRD -> Sekjen / Deputy -> Approved
            <br><br>
            Contact according to approval position for questions or further explanation.
          </div>
        </div>
      </div>
      <div class="absolute w-full p-4 bottom-0 border-t-2 px-8">
        <button 
          class="text-center py-3 text-white font-bold rounded-lg bg-green-2 float-right px-4 border-green-2"
        >
          Submit
        </button>
        <button 
          class="text-center py-3 text-green-2 font-bold rounded-lg bg-green-4 float-right px-4 mr-4 border-green-2"
        >
          Save as Draft
        </button>
      </div>
      <InternalAddMedicalItem
        :isAddFormItem="isAddFormItem"
        @close-form-item="triggerFormItem"
      />
    </div>
  </div>
</template>

<script>
export default {
  name: "AddMedical",
  data() {
    return {
      data: [],
      file: null,
      isAddFormItem: false,
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
    triggerFormItem() {
      this.isAddFormItem = !this.isAddFormItem
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