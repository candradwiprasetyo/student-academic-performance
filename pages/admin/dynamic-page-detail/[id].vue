<template>
  <div class="p-4">
    <form @submit.prevent="saveData">
      <div class="text-lg font-extrabold text-green-2 font-montserrat">Add Dynamic Page</div>
      <div class="mt-8">
        <div class="text-sm"> Title</div>
        <input v-model="data.title" type="text" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required />
      </div>
      <div class="mt-4">
        <div class="text-sm">Content</div>
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
        <div class="text-sm">Name</div>
        <input v-model="data.name" type="text" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required />
      </div>
      <div class="mt-4">
        <div class="text-sm">Order</div>
        <input v-model="data.order" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required type="number" />
      </div>
      <div class="mt-4">
        <div class="text-sm">Type</div>
        <select v-model="data.type_id" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required>
          <option value="1" selected>Our mission</option>
          <option value="2">Leadership</option>
          <option value="3">Management</option>
          <option value="4">Secretariat</option>
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
        title: '',
        content: '',
        is_active: 1,
        img_path: '',
        name: '',
        order: '',
        type_id: 1,
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
        const data = await fetch(config.public.baseURL + '/dynamic-page/' + paramId, { 
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

      formData.append("title", this.data.title);
      formData.append("content", this.data.content);
      formData.append("is_active", this.data.is_active);
      formData.append("name", this.data.name);
      formData.append("order", this.data.order);
      formData.append("type_id", this.data.type_id);
      formData.append("img_path", this.data.img_path);

      let params = ''
      if (this.paramId != 'add') {
        params = `/${this.paramId}`
      }

      const result = await fetch(config.public.baseURL + '/dynamic-page' + params, {
        method: 'POST',
        body: formData,
        headers: {
          Authorization: `Bearer ${token.value}`
        }
      }).then(res => res.json())

      return navigateTo('/admin/dynamic-page')

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