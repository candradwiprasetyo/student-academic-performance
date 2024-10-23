<template>
  <div>
    <div class="rounded-lg p-8 bg-white shadow">
      <div class="flex justify-between">
        <div class="font-black text-lg">Palm Oil Database</div>
      </div>
      <div class="border-primary-4 rounded-lg mt-4">
        <table class="w-full">
          <tr class="text-xs md:text-sm text-left border-b-2 border-gray-100 font-black">
            <th width="30%" class="p-2 px-2 md:px-4">Name</th>
            <th width="15%" class="p-2 px-2 md:px-4">Type</th>
            <th width="10%" class="p-2 px-2 md:px-4"></th>
          </tr>
          <tr v-if="isLoading==true">
            <td colspan="5" class="text-center py-5" >Mengambil data...</td>
          </tr>
          <tr class="text-2xs md:text-xs border-b-2 border-gray-100" v-for="data in data" :key="data.id" v-if="isLoading==false">
            <td class="py-3 md:py-2 px-1 md:px-4">{{ data.name }}</td>
            <td class="py-3 md:py-2 px-1 md:px-4">{{ data.type_name }}</td>
            <td class="py-3 md:py-2 px-1 md:px-4 text-right">
              <a :href="`palm-oil-detail/${data.id}`">
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
  </div>
</template>

<script lang="ts">
definePageMeta({
  layout: 'admin',
  middleware: 'auth' // this should match the name of the file inside the middleware directory 
})

const config = useRuntimeConfig()

export default {
  name: "AdminPalmOil",
  data() {
    return {
      isLoading: true,
      data: [],
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
      const data = await fetch(config.public.baseURL + '/oil-data-master?limit=1000', { 
        headers: {
          Authorization: `Bearer ${token}`
        }
      }).then(res => res.json())
      if ( data?.data.length > 0) {
        this.data = data.data
        this.data.forEach(async element => {
          const dataType = await fetch(config.public.baseURL + '/oil-data-type/' + element.oil_type_id, { 
            headers: {
              Authorization: `Bearer ${this.token}`
            }
          }).then(res => res.json())
          element.type_name = dataType.data.name
        });
      }
      this.isLoading = false
    },
    getOilTypeName(id) {
      const data = fetch(config.public.baseURL + '/oil-data-type/' + id, { 
        headers: {
          Authorization: `Bearer ${this.token}`
        }
      }).then(res => res.json())
      return data?.data?.name
    }
  }
}
</script>