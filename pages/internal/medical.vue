<template>
  <div>
    <InternalHeader :title="'Medical Reimbursement'" />
    <div class="px-6">
      <div class="py-4 text-sm">
        <div class="flex gap-2 w-full">
          <div class="bg-primary-4 py-3 px-4 rounded-lg w-full">
            <div class="flex items-center">
              <span class="text-xs font-bold">Remaining reimbursement plafond</span>
            </div>
            <div class="text-2xl font-black mt-2 font-montserrat">Rp50.000.000</div>
            <div class="flex">
              <div class="text-2xs mt-2 font-medium w-1/2">
                <div>Used</div>
                <div class="-mt-1">Rp70.000.000</div>
              </div>
              <div class="text-2xs mt-2 font-medium w-1/2">
                <div>Total</div>
                <div class="-mt-1">Rp120.000.000</div>
              </div>
            </div>
            <div class="mt-2 text-primary-3 text-xs">
              this plafond will reset every year
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="border-dashed border-t-2">
      <div class="py-4 text-sm px-6">
        <div>
          <select class="py-2 px-3 rounded-lg border-2 w-full">
            <option value="" default selected hidden>Select date range</option>
            <option value="1">February</option>
            <option value="2">March</option>
          </select>
        </div>
        <table class="text-sm w-full text-center rounded-lg mt-4 bg-primary-4 ">
          <tr class="font-bold ">
            <td class="py-4">Period & Info</td>
            <td class="py-4">Status</td>
            <td class="py-4" width="10%"></td>
          </tr>
        </table>
        <div class="overflow-y-auto h-[calc(100vh-400px)]">
          <table class="text-xs w-full text-center">
            <tr class="border-b">
              <td class="py-4 text-left text-sm">
                October 2023<br>
                <span class="text-xs">Rp1.200.000 / 3 Item</span>
              </td>
              <td class="py-4">
                <strong>On Check</strong><br>
                10/10/2023<br>
                (By HRD)
              </td>
              <td class="py-4">
                <img
                  src="~/assets/images/eye.svg"
                  class="mx-auto"
                  alt="Eye"
                  width="32"
                  height="32"
                />
              </td>
            </tr>
            <tr class="border-b">
              <td class="py-4 text-left text-sm">
                November 2023<br>
                <span class="text-xs">Rp1.500.000 / 5 Item</span>
              </td>
              <td class="py-4">
                <strong class="text-red-2">Rejected</strong><br>
                10/10/2023<br>
                (By HRD)
              </td>
              <td class="py-4">
                <img
                  src="~/assets/images/eye.svg"
                  class="mx-auto"
                  alt="Eye"
                  width="32"
                  height="32"
                />
              </td>
            </tr>
            <tr class="border-b">
              <td class="py-4 text-left text-sm">
                December 2023<br>
                <span class="text-xs">Rp200.000 / 1 Item</span>
              </td>
              <td class="py-4">
                <strong class="text-green-2">Approved</strong><br>
                10/10/2023<br>
                (By HRD)
              </td>
              <td class="py-4">
                <img
                  src="~/assets/images/eye.svg"
                  class="mx-auto"
                  alt="Eye"
                  width="32"
                  height="32"
                />
              </td>
            </tr>
            <tr class="border-b">
              <td class="py-4 text-left text-sm">
                January 2024<br>
                <span class="text-xs">Rp1.200.000 / 3 Item</span>
              </td>
              <td class="py-4">
                <strong>On Check</strong><br>
                10/10/2023<br>
                (By HRD)
              </td>
              <td class="py-4">
                <img
                  src="~/assets/images/eye.svg"
                  class="mx-auto"
                  alt="Eye"
                  width="32"
                  height="32"
                />
              </td>
            </tr>
            <tr class="border-b">
              <td class="py-4 text-left text-sm">
                February 2024<br>
                <span class="text-xs">Rp1.200.000 / 3 Item</span>
              </td>
              <td class="py-4">
                <strong class="text-red-2">Rejected</strong><br>
                10/10/2023<br>
                (By HRD)
              </td>
              <td class="py-4">
                <img
                  src="~/assets/images/eye.svg"
                  class="mx-auto"
                  alt="Eye"
                  width="32"
                  height="32"
                />
              </td>
            </tr>
            <tr class="border-b">
              <td class="py-4 text-left text-sm">
                March 2024<br>
                <span class="text-xs">Rp1.700.000 / 4 Item</span>
              </td>
              <td class="py-4">
                <strong class="text-green-2">Approved</strong><br>
                10/10/2023<br>
                (By HRD)
              </td>
              <td class="py-4">
                <img
                  src="~/assets/images/eye.svg"
                  class="mx-auto"
                  alt="Eye"
                  width="32"
                  height="32"
                />
              </td>
            </tr>
          </table>
        </div>
      </div>
      <InternalButtonCreate 
        @create-data="triggerForm"
      />
      <InternalAddMedical
        :isAddForm="isAddForm"
        @close-form="triggerForm"
      />
    </div>
  </div>
</template>

<script lang="ts">

export default {
  name: "InternalMedical",
  data() {
    return {
      isMenuOpen: false,
      activeTab: 1,
      isAddForm: false,
    }
  },
  methods: {
    triggerMenu() {
      this.isMenuOpen = !this.isMenuOpen
    },
    changeTab(id) {
      this.activeTab = id;
    },
    triggerForm() {
      this.isAddForm = !this.isAddForm
    },
  },
}
</script>
