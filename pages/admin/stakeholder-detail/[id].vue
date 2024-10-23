<template>
  <div class="p-4">
    <form @submit.prevent="saveData">
      <div class="text-lg font-extrabold text-green-2 font-montserrat">Add Stakeholder</div>
      <div class="mt-8">
        <div class="text-sm">Name</div>
        <input v-model="data.name" type="text" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required />
      </div>
      <div class="mt-4">
        <div class="text-sm">Country</div>
        <select v-model="data.member_id" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required>
          <option :value="country.id" v-for="country in dataCountry" :key="country.id">{{ country.member_name }}</option>
        </select>
      </div>
      <div class="mt-4">
        <div class="text-sm">Type</div>
        <select v-model="data.stakeholder_type_id" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required @change="onChangeType($event)">
          <option value="1" selected>Company</option>
          <option value="2">Association</option>
          <option value="3">Organization</option>
          <option value="4">Government</option>
          <option value="5">Academician</option>
        </select>
      </div>
      <div class="mt-4">
        <div class="text-sm">{{ typeName }}</div>
        <input v-model="data.institution" type="text" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required />
      </div>
      <div class="mt-4">
        <div class="text-sm">Designation</div>
        <input v-model="data.designation" type="text" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" />
      </div>
      <div class="mt-4">
        <div class="text-sm">Address</div>
        <textarea v-model="data.address" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" rows="5"></textarea>
      </div>
      <div class="mt-4">
        <div class="text-sm">Phone</div>
        <input v-model="data.phone" type="text" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" />
      </div>
      <div class="mt-4">
        <div class="text-sm">Email</div>
        <input v-model="data.email" type="text" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" />
      </div>
      <div class="mt-4">
        <div class="text-sm">PIC</div>
        <input v-model="data.contact" type="text" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" />
      </div>
      <div class="mt-4">
        <div class="text-sm">Planted Area</div>
        <input v-model="data.planted_area" type="text" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" />
      </div>
      <div class="mt-4">
        <div class="text-sm">Production</div>
        <input v-model="data.production" type="text" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" />
      </div>
      <div class="mt-4">
        <div class="text-sm">Percentage</div>
        <input v-model="data.percentage" type="text" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" />
      </div>
      <div class="mt-4">
        <div class="text-sm">Export Total</div>
        <input v-model="data.export_total" type="text" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" />
      </div>
      <div class="mt-4">
        <div class="text-sm">Export Destination</div>
        <input v-model="data.export_destination" type="number" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" />
      </div>
      <div class="mt-4">
        <div class="text-sm">Type Product</div>
        <input v-model="data.type_product" type="text" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" />
      </div>
      <div class="mt-4">
        <div class="text-sm">Total GDP</div>
        <input v-model="data.total_gdp" type="text" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" />
      </div>

      <div class="flex justify-end gap-2 mt-4">
        <div class="flex items-center gap-2 px-4 py-2 text-sm font-bold text-white bg-orange-400 rounded-lg cursor-pointer"
          @click="goToPrev()">
          Cancel
        </div>
        <button class="flex items-center gap-2 px-4 py-2 text-sm font-bold text-white rounded-lg bg-green-2"
          :disabled="isSubmit"
          >
          {{ isSubmit ? 'Saving...' : 'Save' }}
        </button>
      </div>
    </form>
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
// const paramId = route.params.id;

export default {
  name: "DynamicPageDetail",
  data() {
    return {
      data: {
        member_id: '1',
        stakeholder_type_id: '1',
        address: '',
        phone: '',
        email: '',
        contact: '',
        planted_area: '',
        production: '',
        percentage: '',
        export_total: '',
        export_destination: '',
        type_product: '',
        total_gdp: '',
        name: '',
        institution: '',
        designation: '',
      },
      token: '',
      paramId: '',
      isSubmit: false,
      typeName: 'Company Name',
      dataCountry: [],
    }
  },
  mounted() {
    this.paramId = this.$route.params.id
    this.loadToken(this.paramId)
  },
  methods: {
    loadToken(paramId) {
      const token = useCookie('token')
      this.token = token.value
      this.loadData(token.value, paramId)
      this.loadCountry(token.value)
    },
    async loadCountry(token) {
      const data = await fetch(config.public.baseURL + '/member?limit=1000', { 
        headers: {
          Authorization: `Bearer ${token}`
        }
      }).then(res => res.json())
      if ( data?.data.length > 0) {
        this.dataCountry = data.data
      }
    },
    onChangeType(event) {
      console.log(event.target.value)
      switch(event.target.value) {
        case '1': this.typeName = 'Company Name'; break;
        case '2': this.typeName = 'Association Name'; break;
        case '3': this.typeName = 'Organization Name'; break;
        case '4': this.typeName = 'Government Institution'; break;
        case '5': this.typeName = 'Academic Institution'; break;
      }
    },
    async loadData(token, paramId) {
      if (paramId != 'add') {
        const data = await fetch(config.public.baseURL + '/stakeholder/' + paramId, { 
        headers: {
          Authorization: `Bearer ${token}`
        }
      }).then(res => res.json())
        if ( data?.code == 200) {
          this.data = data.data
          switch(this.data.stakeholder_type_id) {
            case 1: this.typeName = 'Company Name'; break;
            case 2: this.typeName = 'Association Name'; break;
            case 3: this.typeName = 'Organization Name'; break;
            case 4: this.typeName = 'Government Institution'; break;
            case 5: this.typeName = 'Academic Institution'; break;
          }
        }
      }
    },
    async saveData() {
      this.isSubmit = true
      const token = useCookie('token')
      let formData = new FormData();

      formData.append("member_id", this.data.member_id);
      formData.append("stakeholder_type_id", this.data.stakeholder_type_id);
      formData.append("address", this.data.address);
      formData.append("phone", this.data.phone);
      formData.append("email", this.data.email);
      formData.append("contact", this.data.contact);
      formData.append("planted_area", this.data.planted_area);
      formData.append("production", this.data.production);
      formData.append("percentage", this.data.percentage);
      formData.append("export_total", this.data.export_total);
      formData.append("export_destination", this.data.export_destination);
      formData.append("type_product", this.data.type_product);
      formData.append("total_gdp", this.data.total_gdp);
      formData.append("name", this.data.name);
      formData.append("institution", this.data.institution);
      formData.append("designation", this.data.designation);

      let params = ''
      if (this.paramId != 'add') {
        params = `/${this.paramId}`
      }

      const result = await fetch(config.public.baseURL + '/stakeholder' + params, {
        method: 'POST',
        body: formData,
        headers: {
          Authorization: `Bearer ${token.value}`
        }
      }).then(res => res.json())

      return navigateTo('/admin/stakeholder')

    },
    goToPrev() {
      this.$router.go(-1)
    },
  }
}
</script>