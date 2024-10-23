<template>
  <div>
    <InternalHeader />
    <div class="px-6 py-4 pb-8 bg-primary-4 text-sm">
      <div class="font-black mb-4">Today's Info</div>
      <carousel :items-to-show="1.2">
        <slide v-for="slide in 5" :key="slide">
          <div class="w-full mr-4">
            <img
              src="~/assets/images/banner-internal.png"
              class="mx-auto rounded-xl"
              alt="Banner"
            />
            <div class="mt-2 font-black">Lets Be #YoungElaeis Ambassador!!</div>
          </div>
        </slide>
        <template #addons>
          <pagination />
        </template>
      </carousel>
    </div>
    <div class="px-6 mt-4">
      <div class="py-4 text-sm">
        <div class="font-black">Approval Request Update</div>
        <div class="flex text-primary-3 font-bold w-full mt-3 text-center">
          <div class="w-1/3 py-2" :class="activeTab==1?'bg-green-4 text-green-2 rounded-lg border-green-2':''" @click="changeTab(1)">Leave</div>
          <div class="w-1/3 py-2" :class="activeTab==2?'bg-green-4 text-green-2 rounded-lg border-green-2':''" @click="changeTab(2)">Medical</div>
          <div class="w-1/3 py-2" :class="activeTab==3?'bg-green-4 text-green-2 rounded-lg border-green-2':''" @click="changeTab(3)">Attendance</div>
        </div>
        <table class="text-xs w-full text-center" v-if="activeTab==1">
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
        <table class="text-xs w-full" v-if="activeTab==2">
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
        </table>
        <table class="text-xs w-full" v-if="activeTab==3">
          <tr class="border-b">
            <td class="py-4">10/10/2023</td>
            <td class="py-4">08:10:59 <br>-<br>16:10:59 </td>
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
                @click="triggerDetailAttendance"
              />
            </td>
          </tr>
          <tr class="border-b">
            <td class="py-4">09/10/2023</td>
            <td class="py-4">08:10:59 <br>-<br>16:10:59 </td>
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
                @click="triggerDetailAttendance"
              />
            </td>
          </tr>
          <tr class="border-b">
            <td class="py-4">08/10/2023</td>
            <td class="py-4">09:10:59  <br>-<br>16:10:59 </td>
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
                @click="triggerDetailAttendance"
              />
            </td>
          </tr>
        </table>
        <div class="mt-2 text-center py-3">
          See All {{ activeTab==1?'Leave':activeTab==2?'Medical':'Attendance' }} Request List
        </div>
      </div>
    </div>
    <div class="px-6 pt-8 pb-4">
      <div class="font-black text-sm">Monthly Attendances Report</div>
      <div class="mt-1 text-2xs">January</div>
      <div class="mt-2 flex gap-2 w-full">
        <div class="bg-primary-4 p-2 rounded-lg w-1/3">
          <div class="flex items-center">
            <span class="text-xs">On Time</span>
            <div class="mx-auto w-2 h-2 rounded-full bg-green-500"></div>
          </div>
          <div class="text-2xl font-black">53</div>
        </div>
        <div class="bg-primary-4 p-2 rounded w-1/3">
          <div class="flex items-center">
            <span class="text-xs">Late</span>
            <div class="mx-auto w-2 h-2 rounded-full bg-green-500"></div>
          </div>
          <div class="text-2xl font-black">3</div>
        </div>
        <div class="bg-primary-4 p-2 rounded w-1/3">
          <div class="flex items-center">
            <span class="text-xs">Total</span>
          </div>
          <div class="text-2xl font-black">56</div>
        </div>
      </div>
      <div class="mt-2 text-center py-3">See All Attendances List</div>
    </div>
    <div class="px-6 mt-4">
      <div class="py-4 text-sm">
        <div class="font-black">Today’s Employee Leave Info</div>
        <table class="w-full">
          <tr class="border-b">
            <td class="py-4">
              Candra Dwi Prasetyo<br>
              <span class="text-xs">Human Resource Department</span>
            </td>
            <td class="py-4">
              Annual Leave
            </td>
          </tr>
          <tr class="border-b">
            <td class="py-4">
              Adri Driyo Utomo<br>
              <span class="text-xs">Finance</span>
            </td>
            <td class="py-4">
              Special Leave
            </td>
          </tr>
          <tr class="border-b">
            <td class="py-4">
              Wawan Setiawan<br>
              <span class="text-xs">Information Technology</span>
            </td>
            <td class="py-4">
              Religious Leave
            </td>
          </tr>
        </table>
      </div>
      <InternalModalDetailAttendance
        :isDetailOpen="isDetailAttendanceOpen"
        @close-detail="triggerDetailAttendance"
      />
      <InternalModalDetailLeave
        :isDetailOpen="isDetailLeaveOpen"
        @close-detail="triggerDetailLeave"
      />
    </div>
  </div>
</template>

<script lang="ts">

definePageMeta({
  middleware: 'auth-internal' 
})

import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'

export default {
  name: "InternalDashboard",
  components: {
    Carousel,
    Slide,
    Pagination,
    Navigation,
  },
  data() {
    return {
      isMenuOpen: false,
      activeTab: 1,
      isDetailAttendanceOpen: false,
      isDetailLeaveOpen: false,
    }
  },
  methods: {
    triggerMenu() {
      this.isMenuOpen = !this.isMenuOpen
    },
    changeTab(id) {
      this.activeTab = id
    },
    triggerDetailAttendance() {
      this.isDetailAttendanceOpen = !this.isDetailAttendanceOpen
    },
    triggerDetailLeave() {
      this.isDetailLeaveOpen = !this.isDetailLeaveOpen
    },
  },
}
</script>

<style>
.carousel__pagination-button::after {
  width: 8px;
  height: 8px;
  border-radius: 100%;
  background-color: #cccccc;
}

.carousel__pagination-button--active::after {
  background-color: #47A102;
}


</style>