<template>
  <div>
    <div class="left-0 fixed w-full min-h-screen z-30 bg-white c-form-item" :class="isAddFormItem ? 'c-form-item--open': ''">
      <div class="py-4 px-8 flex justify-between border-b">
        <div class="font-bold text-lg w-full">Add New Item</div>
        <img
          src="~/assets/images/cross.svg"
          class="mx-auto"
          alt="Close"
          width="32"
          height="32"
          @click="closeFormItem()"
        />
      </div>
      <div class="overflow-auto h-[calc(100vh-62px)] pb-40">
        <div class="py-4 px-8">
          <div class="text-primary-1">
            <div class="text-sm">Medical Type</div>
            <select class="py-2 px-3 rounded-lg border-2 w-full text-sm">
              <option value="1">Medicines</option>
            </select>
          </div>
          <div class="mt-5 text-primary-1">
            <div class="text-sm">Item name</div>
            <input
              v-model="data.date"
              type="text"
              placeholder="Type item name"
              name="date"
              class="w-full text-xs rounded-lg py-2 px-4 border-primary-3"
              required
            />
          </div>
          <div class="mt-5 text-primary-1">
            <div class="text-sm">Nominal Price</div>
            <input
              v-model="data.date"
              type="text"
              placeholder="Rp"
              name="date"
              class="w-full text-xs rounded-lg py-2 px-4 border-primary-3"
              required
            />
          </div>
          <div class="mt-5 text-primary-1">
            <div class="text-sm">Description</div>
            <textarea class="w-full text-xs rounded-lg py-2 px-4 border-primary-3" rows="8" placeholder="Type item description"></textarea>
          </div>
          <div class="mt-5">
            <div class="text-sm">Upload Supported File</div>
            <div class="flex gap-2">
              <div class="flex-grow">
                <div :class="file?.name ? '' : 'text-primary-3'" class="w-full text-xs rounded-lg py-2 px-4 border-primary-3">{{ (file?.name) ? file?.name : 'Upload Supported File'}}</div>
              </div>
              <div class="flex-none"><p><InternalFileSelect v-bind:value="file" @input="file = $event"></InternalFileSelect></p></div>
            </div>
          </div>
        </div>
      </div>
      <div class="absolute w-full p-4 bottom-0 border-t-2">
        <button 
          class="text-center py-3 text-white font-bold rounded-lg bg-green-2 float-right px-4"
        >
          Add Item
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "AddMedicalItem",
  data() {
    return {
      data: [],
      file: null,
    }
  },
  props: {
    isAddFormItem: {
      type: Boolean,
      required: false,
    },
  },
  methods: {
    closeFormItem() {
      this.$emit('close-form-item');
    },
  }
};
</script>

<style>
  .c-form-item {
    bottom: -100vh;
    transition: all 0.3s ease-in-out;
  }

  .c-form-item--open {
    bottom: 0px;
  }
</style>