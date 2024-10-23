<template>
  <div>
    <div class="flex w-full min-h-screen">
      <div class="relative flex-none px-6 py-16 border-gray-100 shadow-lg w-80 text-sm">
        <div class="flex gap-2">
          <div class="flex-none w-12">
            <img
              src="~/assets/images/logo-admin.svg"
              class="w-12 h-12 mx-auto"
              alt="Logo admin"
            />
          </div>
          <div class="text-lg font-extrabold font-montserrat">
            CPOPC<br>
            DigiApp
          </div>
        </div>
        <div class="mt-8">
          <NuxtLink to="/admin/event">
            <div 
              class="flex items-center gap-2 px-6 py-3 font-bold rounded-lg"
              :class="($route.name=='admin-event' || $route.name=='event-detail-id') ? 'bg-green-2 text-white' : 'text-black border-b'"
            >
              <span class="flex-grow">Event</span>
            </div>
          </NuxtLink>
        </div>
        <div v-if="dataUser.role_id!=6">
          <div>
            <NuxtLink to="/admin/dynamic-page">
              <div 
                class="flex items-center gap-2 px-6 py-3 font-bold rounded-lg"
                :class="($route.name=='admin-dynamic-page' || $route.name == 'admin-dynamic-page-detail-id') ? 'bg-green-2 text-white' : 'text-black border-b'"
              >
                <span class="flex-grow">Dynamic Page</span>
              </div>
            </NuxtLink>
          </div>
          <div>
            <NuxtLink to="/admin/palm-oil">
              <div class="flex items-center gap-2 px-6 py-3 font-bold rounded-lg" :class="($route.name=='admin-palm-oil' || $route.name == 'admin-palm-oil-detail-id') ? 'bg-green-2 text-white' : 'text-black border-b'">
                <span class="flex-grow">Palm Oil Database</span>
              </div>
            </NuxtLink>
          </div>
          <div>
            <NuxtLink to="/admin/news">
              <div class="flex items-center gap-2 px-6 py-3 font-bold rounded-lg" :class="($route.name=='admin-news' || $route.name == 'admin-news-detail-id') ? 'bg-green-2 text-white' : 'text-black border-b'">
                <span class="flex-grow">News</span>
              </div>
            </NuxtLink>
          </div>
          <div>
            <NuxtLink to="/admin/blog">
              <div class="flex items-center gap-2 px-6 py-3 font-bold rounded-lg" :class="($route.name=='admin-blog' || $route.name == 'admin-blog-detail-id') ? 'bg-green-2 text-white' : 'text-black border-b'">
                <span class="flex-grow">Blog</span>
              </div>
            </NuxtLink>
          </div>
          <div>
            <NuxtLink to="/admin/gallery">
              <div class="flex items-center gap-2 px-6 py-3 font-bold rounded-lg" :class="($route.name=='admin-gallery' || $route.name == 'admin-gallery-detail-id') ? 'bg-green-2 text-white' : 'text-black border-b'">
                <span class="flex-grow">Gallery</span>
              </div>
            </NuxtLink>
          </div>
          <div>
            <NuxtLink to="/admin/news-video">
              <div class="flex items-center gap-2 px-6 py-3 font-bold rounded-lg" :class="($route.name=='admin-news-video' || $route.name == 'admin-news-video-detail-id') ? 'bg-green-2 text-white' : 'text-black border-b'">
                <span class="flex-grow">Video</span>
              </div>
            </NuxtLink>
          </div>
          <div>
            <NuxtLink to="/admin/archive">
              <div class="flex items-center gap-2 px-6 py-3 font-bold rounded-lg" :class="($route.name=='admin-archive' || $route.name == 'admin-archive-detail-id') ? 'bg-green-2 text-white' : 'text-black border-b'">
                <span class="flex-grow">Archive</span>
              </div>
            </NuxtLink>
          </div>
          <div>
            <NuxtLink to="/event-participant">
              <div class="flex items-center gap-2 px-6 py-3 font-bold rounded-lg" :class="($route.name=='event-participant') ? 'bg-green-2 text-white' : 'text-black border-b'">
                <span class="flex-grow">Participant</span>
              </div>
            </NuxtLink>
          </div>
          <div>
            <NuxtLink to="/admin/country">
              <div class="flex items-center gap-2 px-6 py-3 font-bold rounded-lg" :class="($route.name=='admin-country') ? 'bg-green-2 text-white' : 'text-black border-b'">
                <span class="flex-grow">Country</span>
              </div>
            </NuxtLink>
          </div>
          <div>
            <NuxtLink to="/admin/stakeholder">
              <div class="flex items-center gap-2 px-6 py-3 font-bold rounded-lg" :class="($route.name=='admin-stakeholder') ? 'bg-green-2 text-white' : 'text-black border-b'">
                <span class="flex-grow">Stakeholder Management</span>
              </div>
            </NuxtLink>
          </div>
        </div>
        <div class="absolute bottom-4 text-2xs">Copyright © {{ new Date().getFullYear() }} cpopc.net. All rights reserved.</div>
      </div>
      <div class="flex-grow">
        <div class="min-h-screen px-8 py-16 bg-gray-50">
          <div class="flex flex-row-reverse gap-4 ">
            <div class="flex-none">
              <img
                src="~/assets/images/logout.svg"
                class="float-right w-8 h-8 mx-auto cursor-pointer md:w-9 md:h-9"
                alt="Logout"
                @click="togglePopupLogout"
              />
            </div>
            <div class="flex-none">
              <div class="text-xs md:text-base font-black mt-[2px] md:-mt-[6px] text-right">{{ dataUser?.name  }}</div>
              <div class="font-medium text-2xs md:text-sm">
                {{ dataUser?.email  }}
              </div>
            </div>
          </div>
          <div class="mt-4">
            <slot />
          </div>
        </div>
      </div>
    </div>
    <AdminPopup
      :title="'Logout'"
      :message="'Are you sure you want to logout ?'"
      :type="'popup-logout'"
      :buttonText="'Logout'"
      @close-popup="togglePopupLogout"
      @action="clickLogout"
      v-if="isPopupLogout"
    />
  </div>
</template>

<script lang="ts">

// definePageMeta({
//   middleware: 'auth' // this should match the name of the file inside the middleware directory 
// })

import { mapActions } from 'pinia'
import { useAuthStore } from '../store/auth';

export default {
  name: "AdminLayout",
  data() {
    return {
      isPopupLogout: false,
      dataUser: ''
    }
  },
  mounted() {
    this.loadUser()
  },
  methods: {
    ...mapActions(useAuthStore, { logout: 'logUserOut' }),
    loadUser() {
      const user = useCookie('user')
      this.dataUser = user.value
    },
    clickLogout() {
      this.logout()
      this.$router.push('/admin-page')
    },
    togglePopupLogout() {
      this.isPopupLogout = !this.isPopupLogout
    }
  }
}
</script>