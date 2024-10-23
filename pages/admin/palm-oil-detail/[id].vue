<template>
  <div class="p-4">
    <div class="text-lg font-extrabold text-green-2 font-montserrat">Detail Palm Oil Database</div>
    <div class="mt-8">
      <div class="text-sm"> Name</div>
      <input v-model="data.name" type="text" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required />
    </div>
    <div class="mt-4">
      <div class="text-sm">Content</div>
      <textarea v-model="data.description" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" rows="5" required></textarea>
    </div>
    <div class="mt-4 border">
      <table class="w-full bg-white">
        <tr class="text-xs md:text-sm text-left border-b-2 border-gray-100 font-black">
          <th class="p-5 px-2 md:px-4">Year</th>
          <th width="9%" v-for="dataHead in dataDetail[0]?.detail" :key="dataHead.id">{{ dataHead.name  }}</th>
        </tr>
        <tr class="text-2xs md:text-xs border-b-2 border-gray-100" v-for="detail, indexDetail in dataDetail" :key="dataDetail.id">
          <td class="py-4 md:py-3 px-1 md:px-4">{{ detail.year }}</td>
          <td v-for="dataBody, indexBodyDetail in detail.detail" :key="dataBody.id">
            <input :value="(dataBody.id == savedId) ? 'Saved' : dataBody.qty" class="p-1 border w-20" :name="`i_input_${dataBody.id}`" @change="changeDetail(dataBody.id, indexBodyDetail, indexDetail, $event)" :class="(dataBody.id == savedId) ? 'bg-green-300' : ''"  />
          </td>
        </tr>
      </table>
    </div>
    <div class="flex justify-end gap-2 mt-4">
      <button class="flex items-center gap-2 px-4 py-2 text-sm font-bold text-white bg-orange-400 rounded-lg"
        @click="goToPrev()">
        Cancel
      </button>
      <button class="flex items-center gap-2 px-4 py-2 text-sm font-bold text-white rounded-lg bg-green-2"
        @click="saveData()">
        Save
      </button>
    </div>

  </div>
</template>

<script lang="ts" setup>
definePageMeta({
  layout: 'admin',
})
</script>

<script lang="ts">
const config = useRuntimeConfig()
const route = useRoute()

export default {
  name: "PalmOilDetail",
  data() {
    return {
      data: {
        name: '',
        description: '',
      },
      dataDetail: [],
      token: '',
      paramId: '',
      savedId: '',
    }
  },
  mounted() {
    this.paramId = this.$route.params.id
    this.loadData(this.paramId)
    if (this.paramId) {
      this.loadDetail(this.paramId)
    }
  },
  methods: {
    async loadData(urlId) {
      const token = useCookie('token')
      this.token = token.value
      if (urlId != 'add') {
        const data = await fetch(config.public.baseURL + '/oil-data-master/' + urlId, { 
        headers: {
          Authorization: `Bearer ${this.token}`
        }
      }).then(res => res.json())
        if ( data?.code == 200) {
          this.data = data.data
        }
      }
    },
    loadDetail(urlId) {
      this.loadDataDetail(urlId)
    },
    async loadDataDetail(urlId) {
      if (urlId != 'add') {
        const data = await fetch(config.public.baseURL + '/oil-data/', { 
          headers: {
            Authorization: `Bearer ${this.token}`
          }
        }).then(res => res.json())
        
        if ( data?.code == 200) {
          this.dataDetail = data.data
        }
      
        this.dataDetail = this.dataDetail.filter((s) => s.oil_master_id === Number(urlId))

      }
    },
    async saveData() {
      const token = useCookie('token')
      let formData = new FormData();

      formData.append("name", this.data.name);
      formData.append("description", this.data.description);

      let params = ''
      if (this.paramId != 'add') {
        params = `/${this.paramId}`
      }
      const result = await fetch(config.public.baseURL + '/oil-data-master' + params, {
        method: 'POST',
        body: formData,
        headers: {
          Authorization: `Bearer ${token.value}`
        }
      }).then(res => res.json())

      return navigateTo('/admin/palm-oil')

    },
    goToPrev() {
      this.$router.go(-1)
    },
    async changeDetail(id, indexBodyDetail, indexDetail, event) {
      this.savedId = id
      const oldValue = event.target.value
      const token = useCookie('token')
      let formData = new FormData()
      formData.append("qty", event.target.value)
      const result = await fetch(config.public.baseURL + '/oil-data-detail/' + id, {
        method: 'POST',
        body: formData,
        headers: {
          Authorization: `Bearer ${token.value}`
        }
      }).then(res => res.json())

      this.dataDetail[indexDetail].detail[indexBodyDetail].qty = oldValue
      
      setTimeout(()=>{
        this.savedId = ''
      }, 1000);
    },
  }
}
</script>