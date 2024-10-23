<template>
  <div>
    <div class="rounded-lg p-8 bg-white shadow">
      <div class="flex justify-between">
        <div class="font-black text-lg">Stakeholder Management</div>
        <a href="stakeholder-detail/add">
          <div class="bg-green-2 rounded-lg	py-2 px-4 text-white font-bold items-center flex gap-2 text-sm ">
            <span class="flex-grow">Add New</span>
          </div>
        </a>
      </div>
      <div class="border-primary-4 rounded-lg mt-4">
        <table class="w-full">
          <tr class="text-xs md:text-sm text-left border-b-2 border-gray-100 font-black">
            <th class="p-2 px-2 md:px-4">Country</th>
            <th class="p-2 px-2 md:px-4">Type</th>
            <th class="p-2 px-2 md:px-4">Name</th>
            <th width="30%" class="p-2 px-2 md:px-4">Product</th>
            <th width="10%" class="p-2 px-2 md:px-4"></th>
          </tr>
          <tr v-if="isLoading==true">
            <td colspan="5" class="text-center py-5" >Mengambil data...</td>
          </tr>
          <tr class="text-2xs md:text-xs border-b-2 border-gray-100" v-for="data in data" :key="data.id" v-if="isLoading==false">
            <td class="py-3 md:py-2 px-1 md:px-4">
              <img
                :src="data.member.url_flag_img"
                class="w-12"
                alt="event"
              />
            </td>
            <td class="py-3 md:py-2 px-1 md:px-4">{{ data?.type?.name }}</td>
            <td class="py-3 md:py-2 px-1 md:px-4">{{ data.institution + ' - ' + data.name }}</td>
            <td class="py-3 md:py-2 px-1 md:px-4">{{ data.type_product }}</td>
            <td class="py-3 md:py-2 px-1 md:px-4 text-right flex">
              <a :href="`stakeholder-detail/${data.id}`">
                <img
                  src="~/assets/images/edit.svg"
                  class="mx-auto inline-block cursor-pointer ml-2"
                  alt="Detail"
                  width="32"
                  height="32"
                />
              </a>
              <img
                src="~/assets/images/delete.svg"
                class="mx-auto inline-block cursor-pointer ml-2"
                alt="Delete"
                width="32"
                height="32"
                @click="confirmDelete(data.id)"
              />
            </td>
          </tr>
        </table>
      </div>
    </div>
    <AdminPopup
      :title="`Delete stakeholder`"
      :message="`Are you sure you want to delete this data?`"
      :type="'popup-inactive-event'"
      :buttonText="`Delete stakeholder`"
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
  name: "AdminStakeholder",
  data() {
    return {
      isLoading: true,
      data: [],
      isPopupStatus: false,
      selectedStatus: {
        id: '',
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
    togglePopupStatus(){
      this.isPopupStatus = !this.isPopupStatus
    },
    confirmDelete(id) {
      this.selectedStatus.id = id
      this.togglePopupStatus()
    },
    async changeStatus() {
      this.togglePopupStatus()
      const body = new FormData();
      await fetch(config.public.baseURL + '/stakeholder/' + this.selectedStatus.id, {
        method: 'DELETE',
        headers: {
          Authorization: `Bearer ${this.token}`
        },
      })
      this.$router.go(0)
    },
  }
}
</script>