<template>
  <div>
    <InternalHeader :title="'Stakeholder Management'" />
    <div class="">
      <div class="py-4 text-sm px-6">
        <!-- <div class="flex gap-2">
          <div class="w-1/2">
            <div class="mb-2 font-bold">Type</div>
            <select class="py-2 px-3 rounded-lg border-2 w-full">
              <option value="" default selected hidden>Select type</option>
              <option value="1">Company</option>
              <option value="2">Association</option>
              <option value="3">Organization</option>
              <option value="4">Government</option>
              <option value="5">Academician</option>
            </select>
          </div>
          <div class="w-1/2">
            <div class="mb-2 font-bold">Country</div>
            <select class="py-2 px-3 rounded-lg border-2 w-full">
              <option value="" default selected hidden>Select country</option>
              <option value="1">Indonesia</option>
              <option value="2">Malaysia</option>
              <option value="3">Brazil</option>
              <option value="4">Colombia</option>
              <option value="5">Costa Rica</option>
              <option value="6">Ghana</option>
              <option value="7">Ecuador</option>
              <option value="8">Honduras</option>
              <option value="9">Guatemala</option>
              <option value="10">Nigeria</option>
              <option value="11">Papua New Guinea</option>
              <option value="12">Thailand</option>
              <option value="13">Côte d'Ivoire</option>
            </select>
          </div>
        </div> -->
        <table class="text-sm w-full text-center rounded-lg mt-4 bg-primary-4 ">
          <tr class="font-bold ">
            <td class="px-2 text-left" width="30%">Country</td>
            <td class="py-4 text-left" width="60%">Name</td>
            <td class="py-4"></td>
          </tr>
        </table>
        <div class="overflow-y-auto h-[calc(100vh-400px)]">
          <table class="w-full">
            <tr v-if="isLoading==true">
              <td colspan="3" class="text-center py-5" >Mengambil data...</td>
            </tr>
            <tr class="border-b" v-for="data in data" :key="data.id" v-if="isLoading==false">
              <td class="py-3 md:py-2 px-2 w-20">
                <img
                  :src="data.member.url_flag_img"
                  class="w-20"
                  alt="event"
                />
              </td>
              <td class="py-4 text-left text-sm w-3/5 pl-5">
                <strong>{{ data.name }}</strong><br>
                {{ data.institution }}<br>
                {{ data.member.member_name }}<br>
                <span class="text-green-2">{{ data.type.name }}</span>
                
              </td>
              <td class="py-4">
                <img
                  src="~/assets/images/eye.svg"
                  class="float-right"
                  alt="Eye"
                  width="32"
                  height="32"
                  @click="triggerModal(data.id)"
                />
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <InternalModalDetailStakeholder
      :isModalOpen="isModalOpen"
      :selectedData="selectedData"
      @close-modal="triggerModal"
    />
  </div>
</template>

<script lang="ts">
const config = useRuntimeConfig()
export default {
  name: "InternalDashboard",
  data() {
    return {
      isModalOpen: false,
      isLoading: true,
      data: [],
      token: '',
      selectedId: '',
      selectedData: [],
    }
  },
  mounted() {
    this.loadToken()
  },
  methods: {
    loadToken() {
      const token = useCookie('token-internal')
      this.token = token.value
      this.loadData(token.value)
    },
    triggerModal(id) {
      this.selectedId = id
      this.selectedData = this.data.find(item => item.id === id);
      this.isModalOpen = !this.isModalOpen
    },
    async loadData(token) {
      const data = await fetch(config.public.baseURL + '/stakeholder?limit=1000', { 
        headers: {
          Authorization: `Bearer ${token}`
        }
      }).then(res => res.json())
      if ( data?.data.length > 0) {
        this.data = data.data
      }
      this.isLoading = false
    },
  },
}
</script>
