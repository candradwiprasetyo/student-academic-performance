<template>
  <div>
    <InternalHeader :title="'Attendances'" />
    <div class="px-6">
      <div class="py-4 text-sm">
        <div class="flex text-primary-3 font-bold w-full mt-3 text-center mb-6">
          <div @click="changeTab(1)" class="w-1/2 py-2" :class="activeTab == 1 ? 'bg-green-4 text-green-2 rounded-lg border-green-2' : ''">Reports</div>
          <div @click="changeTab(2)" class="w-1/2 py-2" :class="activeTab == 2 ? 'bg-green-4 text-green-2 rounded-lg border-green-2' : ''">Request History</div>
        </div>
        <div v-if="activeTab==1">
          <div>
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
          <div class="mt-3 text-right text-xs text-primary-3">
            *Selected Month Report
          </div>
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
        </div>
        <table class="text-sm w-full text-center rounded-lg mt-3 bg-primary-4 ">
          <tr class="font-bold ">
            <td class="py-4">Date</td>
            <td class="py-4">Time</td>
            <td class="py-4">Status</td>
            <td class="py-4" width="10%"></td>
          </tr>
        </table>
        <div class="overflow-y-auto" :class="activeTab==1?'h-[calc(100vh-400px)]':'h-[calc(100vh-210px)]'" v-if="activeTab==1">
          <table class="text-xs w-full text-center">
            <tr class="border-b" v-for="attendance in dataAttendances" :key="attendance.id">
              <td class="py-4">{{ attendance.date  }}</td>
              <td class="py-4">{{ attendance.check_in  }} <br>-<br>{{ attendance.check_out  }} </td>
              <td class="py-4">
                <strong>{{ attendance.status_name  }}</strong><br>
                {{ attendance.duration_name  }}<br>
              </td>
              <td class="py-4">
                <img
                  src="~/assets/images/eye.svg"
                  class="mx-auto"
                  alt="Eye"
                  width="32"
                  height="32"
                  @click="triggerDetail"
                />
              </td>
            </tr>
          </table>
        </div>
      </div>
      <InternalButtonCreate 
        @create-data="triggerForm"
      />
      <InternalAddAttendance
        :isAddForm="isAddForm"
        @close-form="triggerForm"
      />
      <InternalModalDetailAttendance
        :isDetailOpen="isDetailOpen"
        @close-detail="triggerDetail"
      />
    </div>
  </div>
</template>

<script lang="ts">
const config = useRuntimeConfig()

export default {
  name: "InternalDashboard",
  data() {
    return {
      isMenuOpen: false,
      isDetailOpen: false,
      activeTab: 1,
      dataAttendances: [],
      isAddForm: false,
    }
  },
  mounted() {
    this.loadDataAttendance()
  },
  methods: {
    async loadDataAttendance() {
      const token = useCookie('token-internal')
      const { data: dataAttendances, error } = await useFetch(config.public.baseURL + '/attendance?page=1', {
        headers: {
          Authorization: `Bearer ${token.value}`
        }
      })
      
      if ( dataAttendances?.value?.data) {
        this.dataAttendances = dataAttendances.value.data
      } else {
        // redirect to logout here
      }
    },
    changeTab(id) {
      this.activeTab = id;
    },
    triggerForm() {
      this.isAddForm = !this.isAddForm
    },
    triggerDetail() {
      this.isDetailOpen = !this.isDetailOpen
    },
  },
}
</script>
