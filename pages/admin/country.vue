<template>
  <div>
    <div class="rounded-lg p-8 bg-white shadow">
      <div class="flex justify-between">
        <div class="font-black text-lg">Country</div>
        <a href="country-detail/add">
          <div class="bg-green-2 rounded-lg	py-2 px-4 text-white font-bold items-center flex gap-2 text-sm ">
            <span class="flex-grow">Add New</span>
          </div>
        </a>
      </div>
      <div class="border-primary-4 rounded-lg mt-4">
        <table class="w-full">
          <tr class="text-xs md:text-sm text-left border-b-2 border-gray-100 font-black">
            <th class="p-2 px-2 md:px-4">Flag</th>
            <th class="p-2 px-2 md:px-4">Name</th>
            <th width="30%" class="p-2 px-2 md:px-4">Join Date</th>
            <th width="12%" class="p-2 px-2 md:px-4">Status</th>
            <th width="10%" class="p-2 px-2 md:px-4"></th>
          </tr>
          <tr v-if="isLoading==true">
            <td colspan="5" class="text-center py-5" >Mengambil data...</td>
          </tr>
          <tr class="text-2xs md:text-xs border-b-2 border-gray-100" v-for="data in data" :key="data.id" v-if="isLoading==false">
            <td class="py-3 md:py-2 px-1 md:px-4">
              <img
                :src="data.url_flag_img"
                class="w-20"
                alt="event"
              />
            </td>
            <td class="py-3 md:py-2 px-1 md:px-4">{{ data.member_name }}</td>
            <td class="py-3 md:py-2 px-1 md:px-4">{{ data.member_join_date }}</td>
            <td class="py-3 md:py-2 px-1 md:px-4">
              <div 
                class="rounded-lg p-[6px] pl-0 text-sm font-bold w-36 text-center cursor-pointer" 
                :class="(data.is_active==1) ? 'bg-green-4 text-green-2 border-green-2' : 'bg-red-3 text-red-2 border-red-2'"
              >
                <img
                  :src="`../images/${(data.is_active==1) ? 'check' : 'cross'}.svg`"
                  class="mx-auto inline-block mr-1"
                  alt="check"
                  width="16"
                  height="16"
                />
                {{ data.is_active==1 ? 'Active' : 'Inactive' }}
              </div>
            </td>
            <td class="py-3 md:py-2 px-1 md:px-4 text-right">
              <a :href="`country-detail/${data.id}`">
                <img
                  src="~/assets/images/edit.svg"
                  class="mx-auto inline-block cursor-pointer ml-2"
                  alt="Detail"
                  width="32"
                  height="32"
                />
              </a>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <AdminPopup
      :title="`${(selectedStatus.status)==1 ? 'Inactivate' : 'Activate'} event`"
      :message="`Are you sure you want to  ${(selectedStatus.status)==1 ? 'inactivate' : 'activate'} this data?`"
      :type="'popup-inactive-event'"
      :buttonText="`${(selectedStatus.status)==1 ? 'Inactivate' : 'Activate'} Event`"
      @close-popup="togglePopupStatus"
      @action="changeStatus"
      v-if="isPopupStatus"
    />
  </div>
</template>

<script lang="ts">
definePageMeta({
  layout: 'admin',
  middleware: 'auth' // this should match the name of the file inside the middleware directory 
})

const config = useRuntimeConfig()

export default {
  name: "AdminCountry",
  data() {
    return {
      isLoading: true,
      data: [],
      isPopupStatus: false,
      selectedStatus: {
        id: '',
        status: ''
      },
      token: '',

    }
  },
  mounted() {
    this.loadToken()
  },
  methods: {
    loadToken() {
      const token = useCookie('token')
      this.token = token.value
      this.loadData(token.value)
    },
    async loadData(token) {
      const data = await fetch(config.public.baseURL + '/member?limit=1000', { 
        headers: {
          Authorization: `Bearer ${token}`
        }
      }).then(res => res.json())
      if ( data?.data.length > 0) {
        this.data = data.data
      }
      this.isLoading = false
    },
    togglePopupStatus(){
      this.isPopupStatus = !this.isPopupStatus
    },
    confirmStatus(id, status) {
      this.selectedStatus.id = id
      this.selectedStatus.status = status
      this.togglePopupStatus()
    },
    async changeStatus() {
      this.togglePopupStatus()
      const body = new FormData();
      body.append('is_active', this.selectedStatus.status ? 0 : 1);
      await fetch(config.public.baseURL + '/member/' + this.selectedStatus.id, {
        method: 'POST',
        headers: {
          Authorization: `Bearer ${this.token}`
        },
        body: body,
      })
      this.loadToken()
    },
  }
}
</script>