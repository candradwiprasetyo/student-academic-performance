<template>
  <div>
    <div class="fixed w-full h-screen z-30 bg-white c-modal-detail-stakeholder" :class="isModalOpen ? 'c-modal-detail-stakeholder--open': ''">
      <div class="overflow-auto h-screen text-center p-8 relative">
        <img
          src="~/assets/images/cross.svg"
          class="absolute right-4 top-4"
          alt="Close"
          width="32"
          height="32"
          @click="closeModal()"
        />
        <div class="font-bold text-lg w-full mb-2">{{ selectedData?.institution }}</div>
        <div class="font-bold text-green-2 w-full mb-8">{{ selectedData?.type?.name }}</div>
        <div class="text-left">
          <div class="font-bold mb-2">Name</div>
          <div class="mb-6">{{ selectedData?.name }}</div>
          <div class="font-bold mb-2">Country</div>
          <div class="mb-6">{{ selectedData?.member?.member_name }}</div>
          <div class="font-bold mb-2">Designation</div>
          <div class="mb-6">{{ selectedData?.designation }}</div>
          <div class="font-bold mb-2">Address</div>
          <div class="mb-4">{{ selectedData?.address }}</div>
          <div class="font-bold mb-2">Phone Number</div>
          <div class="mb-6">{{ selectedData?.phone }}</div>
          <div class="font-bold mb-2">Email</div>
          <div class="mb-6">{{ selectedData?.email }}</div>
          <div class="font-bold mb-2">Contact Person</div>
          <div class="mb-6">{{ selectedData?.contact }}</div>
          <div>
            <div class="font-bold mb-2">Total planted area</div>
            <div class="mb-6">{{ selectedData?.planted_area }}</div>
          </div>
          <div>
            <div class="font-bold mb-2">Total production</div>
            <div class="mb-6">{{ selectedData?.production }}</div>
          </div>
          <div>
            <div class="font-bold mb-2">Percentage of smallholders</div>
            <div class="mb-6">{{ selectedData?.percentage }}</div>
          </div>
          <div>
            <div class="font-bold mb-2">Total export </div>
            <div class="mb-6">{{ selectedData?.export_total }}</div>
          </div>
          <div>
            <div class="font-bold mb-2">Export destination countries</div>
            <div class="mb-6">{{ selectedData?.export_destination }}</div>
          </div>
          <div>
            <div class="font-bold mb-2">Type of product produce</div>
            <div class="mb-6">{{ selectedData?.type_product }}</div>
          </div>
          <div>
            <div class="font-bold mb-2">Total GDP from palm oil</div>
            <div class="mb-6">{{ selectedData?.total_gdp }}</div>
          </div>
        </div>
        <button
          class=" text-center w-full py-3 text-green-2 font-bold rounded-lg bg-green-4 mt-8 border-green-2"
          @click="closeModal()"
        >
          Close
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ModalDetailStakeholder",
  data() {
    return {}
  },
  props: {
    isModalOpen: {
      type: Boolean,
      required: false,
    },
    selectedData: {
      type: Object,
      required: false
    }
  },
  methods: {
    closeModal() {
      this.$emit('close-modal');
    },
  }
};
</script>

<style>
  .c-modal-detail-stakeholder {
    bottom: -100vh;
    transition: all 0.3s ease-in-out;
  }

  .c-modal-detail-stakeholder--open {
    bottom: 0;
  }
</style>