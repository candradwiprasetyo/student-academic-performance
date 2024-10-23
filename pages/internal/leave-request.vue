<template>
  <div>
    <InternalHeader :title="'Leave Request'" />
    <div class="px-6">
      <div class="py-4 text-sm">
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
            <td class="py-4">Leave Date</td>
            <td class="py-4">Status</td>
            <td class="py-4" width="10%"></td>
          </tr>
        </table>
        <div class="overflow-y-auto h-[calc(100vh-400px)]">
          <table class="text-xs w-full text-center">
            <tr class="border-b">
              <td class="py-4 text-left text-sm">
                10/10/2023 - 10/10/2023<br>
                <span class="text-xs">1 day</span>
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
                  @click="triggerDetailLeave"
                />
              </td>
            </tr>
            <tr class="border-b">
              <td class="py-4 text-left text-sm">
                05/11/2023 - 05/11/2023<br>
                <span class="text-xs">1 day</span>
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
                  @click="triggerDetailLeave"
                />
              </td>
            </tr>
            <tr class="border-b">
              <td class="py-4 text-left text-sm">
                12/12/2023 - 13/12/2023<br>
                <span class="text-xs">2 days</span>
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
                  @click="triggerDetailLeave"
                />
              </td>
            </tr>
            <tr class="border-b">
              <td class="py-4 text-left text-sm">
                10/10/2023 - 10/10/2023<br>
                <span class="text-xs">1 day</span>
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
                  @click="triggerDetailLeave"
                />
              </td>
            </tr>
            <tr class="border-b">
              <td class="py-4 text-left text-sm">
                05/11/2023 - 05/11/2023<br>
                <span class="text-xs">1 day</span>
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
                  @click="triggerDetailLeave"
                />
              </td>
            </tr>
            <tr class="border-b">
              <td class="py-4 text-left text-sm">
                12/12/2023 - 13/12/2023<br>
                <span class="text-xs">2 days</span>
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
                  @click="triggerDetailLeave"
                />
              </td>
            </tr>
          </table>
        </div>
      </div>
      <InternalButtonCreate 
        @create-data="triggerForm"
      />
      <InternalAddLeaveRequest
        :isAddForm="isAddForm"
        @close-form="triggerForm"
      />
      <InternalModalDetailLeave
        :isDetailOpen="isDetailLeaveOpen"
        @close-detail="triggerDetailLeave"
      />
    </div>
  </div>
</template>

<script lang="ts">

export default {
  name: "InternalDashboard",
  data() {
    return {
      isMenuOpen: false,
      activeTab: 1,
      isAddForm: false,
      isDetailLeaveOpen: false,
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
    triggerDetailLeave() {
      this.isDetailLeaveOpen = !this.isDetailLeaveOpen
    },
  },
}
</script>
