<template>
  <div class="p-4">
    <form @submit.prevent="saveData">
      <div class="text-lg font-extrabold text-green-2 font-montserrat">Add Country</div>
      <div class="mt-8">
        <div class="text-sm">Name</div>
        <input v-model="data.member_name" type="text" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required />
      </div>
      <div class="mt-4">
        <div class="text-sm">Type</div>
        <select v-model="data.member_type_id" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required>
          <option value="1" selected>Member</option>
          <option value="2">Observer</option>
          <option value="3">Guest</option>
        </select>
      </div>
      <div class="mt-4">
        <div class="text-sm">Join Date</div>
        <client-only>
          <v-date-picker v-model="data.member_join_date">
            <template v-slot="{ inputValue, inputEvents }">
              <input id="input-publication-date" name="publication-date" type="text"
                class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" :value="inputValue" v-on="inputEvents"
                placeholder="dd/mm/yyyy" readonly required />
            </template>
          </v-date-picker>
        </client-only>
      </div>
      <div class="mt-4">
        <div class="text-sm">Description</div>
        <textarea v-model="data.content" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" rows="5" required></textarea>
      </div>
      <div class="mt-4">
        <div class="text-sm">Status</div>
        <select v-model="data.is_active" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required>
          <option value="0" selected>Inactive</option>
          <option value="1">Active</option>
        </select>
      </div>
      <div class="mt-4">
        <div class="text-sm">Image</div>
        <div class="mb-4">
          <img :src="data.url_flag_img" width="100" v-if="data.member_flag_img" />
        </div>
        <input type="file" @change="onUploadFiles"/>
        <div class="text-2xs">HD Image <span class="px-2">&#x2022;</span> Max Size : 10 Mb <span
            class="px-2">&#x2022;</span>
          Allowed File : PNG/JPG/JPEG</div>
      </div>
      <div class="mt-4">
        <div class="text-sm">Info Image</div>
        <div class="mb-4">
          <img :src="data.url_info_png" width="100" v-if="data.info_png" />
        </div>
        <input type="file" @change="onUploadFilesInfo"/>
        <div class="text-2xs">HD Image <span class="px-2">&#x2022;</span> Max Size : 10 Mb <span
            class="px-2">&#x2022;</span>
          Allowed File : PNG/JPG/JPEG</div>
      </div>

      <div class="flex justify-end gap-2">
        <div class="flex items-center gap-2 px-4 py-2 text-sm font-bold text-white bg-orange-400 rounded-lg cursor-pointer"
          @click="goToPrev()">
          Cancel
        </div>
        <button class="flex items-center gap-2 px-4 py-2 text-sm font-bold text-white rounded-lg bg-green-2"
          :disabled="isSubmit"
          type="submit"
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
        member_type_id: '1',
        member_name: '',
        member_join_date: '',
        member_flag_img: '',
        member_description: '-',
        content: '',
        is_active: 1,
        info_png: '',
      },
      token: '',
      paramId: '',
      isSubmit: false,
    }
  },
  mounted() {
    this.paramId = this.$route.params.id
    this.loadData(this.paramId)
  },
  methods: {
    async loadData(paramId) {
      const token = useCookie('token')
      this.token = token.value
      if (paramId != 'add') {
        const data = await fetch(config.public.baseURL + '/member/' + paramId, { 
        headers: {
          Authorization: `Bearer ${this.token}`
        }
      }).then(res => res.json())
        if ( data?.code == 200) {
          this.data = data.data
        }
      }
    },
    async saveData() {
      this.isSubmit = true
      const token = useCookie('token')
      let formData = new FormData();

      formData.append("member_type_id", this.data.member_type_id);
      formData.append("member_name", this.data.member_name);
      formData.append("member_join_date", this.formatDatePayload(this.data.member_join_date));
      formData.append("flag_img", this.data.member_flag_img);
      formData.append("content", this.data.content);
      formData.append("member_description", this.data.member_description);
      formData.append("is_active", this.data.is_active);
      formData.append("info_png", this.data.info_png);

      let params = ''
      if (this.paramId != 'add') {
        params = `/${this.paramId}`
      }

      const result = await fetch(config.public.baseURL + '/member' + params, {
        method: 'POST',
        body: formData,
        headers: {
          Authorization: `Bearer ${token.value}`
        }
      }).then(res => res.json())

      return navigateTo('/admin/country')

    },
    goToPrev() {
      this.$router.go(-1)
    },
    onUploadFiles(event: any) {
      const allowExtension = [
        "image/jpeg",
        "image/jpg",
        "image/png",
      ];
      if (
        allowExtension.includes(event.target.files[0].type) &&
        event.target.files[0].size / (1024 * 1024) < 10
      ) {
        this.data.member_flag_img = event.target.files[0];
      } else {
        alert("File too big (> 10MB) or exclude extension")
        return
      }
    },
    onUploadFilesInfo(event: any) {
      const allowExtension = [
        "image/jpeg",
        "image/jpg",
        "image/png",
      ];
      if (
        allowExtension.includes(event.target.files[0].type) &&
        event.target.files[0].size / (1024 * 1024) < 10
      ) {
        this.data.info_png = event.target.files[0];
      } else {
        alert("File too big (> 10MB) or exclude extension")
        return
      }
    },
    formatDatePayload(date: string) {
      let date1 = new Date(date);
      let year = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(date1);
      let month = new Intl.DateTimeFormat('en', { month: '2-digit' }).format(date1);
      let day = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(date1);

      return `${year}-${month}-${day}`
    },
  }
}
</script>