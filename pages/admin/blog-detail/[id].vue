<template>
  <div class="p-4">
    <form @submit.prevent="saveData">
      <div class="text-lg font-extrabold text-green-2 font-montserrat">Add Blog</div>
      <div class="mt-8">
        <div class="text-sm"> Title</div>
        <input v-model="data.title" type="text" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required />
      </div>
      <div class="mt-4">
        <div class="text-sm">Content</div>
        <textarea v-model="data.content" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" rows="5" required></textarea>
      </div>
      <div class="mt-4">
        <div class="text-sm">Publish Date</div>
        <client-only>
          <v-date-picker v-model="data.publish_date">
            <template v-slot="{ inputValue, inputEvents }">
              <input id="input-publication-date" name="publication-date" type="text"
                class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" :value="inputValue" v-on="inputEvents"
                placeholder="dd/mm/yyyy" readonly />
            </template>
          </v-date-picker>
        </client-only>
      </div>
      <div class="mt-4">
        <div class="text-sm">Source</div>
        <input v-model="data.source" type="text" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required />
      </div>
      <div class="mt-4">
        <div class="text-sm">Publish</div>
        <select v-model="data.publish" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required>
          <option value="1">Yes</option>
          <option value="0">No</option>
        </select>
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
          <img :src="data.url_img" width="100" v-if="data.img_path" />
        </div>
        <input type="file" @change="onUploadFiles"/>
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
const { $formatDatePayload } = useNuxtApp()
const config = useRuntimeConfig()
const route = useRoute()

export default {
  name: "BlogDetail",
  data() {
    return {
      data: {
        title: '',
        content: '',
        publish_date: '',
        source: '',
        is_active: 1,
        publish: '',
        img_path: '',
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
        const data = await fetch(config.public.baseURL + '/article/' + paramId, { 
        headers: {
          Authorization: `Bearer ${this.token}`
        }
      }).then(res => res.json())
        if ( data?.code == 200) {
          this.data = data.data
        }
      }
    },
    formatDatePayload(date) {
      let date1 = new Date(date);
      let year = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(date1);
      let month = new Intl.DateTimeFormat('en', { month: '2-digit' }).format(date1);
      let day = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(date1);

      return `${year}-${month}-${day}`
    },
    async saveData() {
      this.isSubmit = true
      const token = useCookie('token')
      let formData = new FormData();

      formData.append("title", this.data.title);
      formData.append("content", this.data.content);
      formData.append("publish_date", this.formatDatePayload(this.data.publish_date));
      formData.append("source", this.data.source);
      formData.append("is_active", this.data.is_active);
      formData.append("publish", this.data.publish);
      formData.append("img_path", this.data.img_path);
      formData.append("type_id", 2);

      let params = ''
      if (this.paramId != 'add') {
        params = `/${this.paramId}`
      }
      
      const result = await fetch(config.public.baseURL + '/article' + params, {
        method: 'POST',
        body: formData,
        headers: {
          Authorization: `Bearer ${token.value}`
        }
      }).then(res => res.json())

      return navigateTo('/admin/blog')

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
        this.data.img_path = event.target.files[0];
      } else {
        alert("File too big (> 10MB) or exclude extension")
        return
      }
      
    }
  }
}
</script>