<template>
  <div>
    <div class="w-full h-screen z-20 bg-gradient-menu rounded-r-3xl c-menu fixed top-0" :class="isMenuOpen ? 'c-menu--open': ''">
      <div class="p-4 text-white text-xl font-montserrat">
        <div class="absolute w-8 h-8 top-4 right-4" @click="closeMenu()">
          <img
            src="~/assets/images/cross-white.svg"
            class="mx-auto"
            alt="close"
            width="32"
            height="32"
          />
        </div>
        <div class="font-medium mb-4">CPOPC Internal System Menu</div>
        <div class="py-4" :class="activeMenu==1?'font-black':''"><span @click="changePage(1, 'dashboard')">Dashboard</span></div>
        <!-- <div class="py-4" :class="activeMenu==2?'font-black':''"><span @click="changePage(2, 'attendances')">Attendances</span></div> -->
        <!-- <div class="py-4" :class="activeMenu==3?'font-black':''"><span @click="changePage(3, 'leave-request')">Leave Request</span></div> -->
        <!-- <div class="py-4" :class="activeMenu==4?'font-black':''"><span @click="changePage(4, 'medical')">Medical Reimbursement</span></div> -->
        <div class="py-4" :class="activeMenu==5?'font-black':''"><span @click="changePage(4, 'stakeholder')">Stakeholder Management</span></div>
        <!-- <div class="py-4" :class="activeMenu==6?'font-black':''"><span @click="changePage(5, 'profile')">Profile</span></div> -->
        <div class="py-4" :class="activeMenu==9?'font-black':''"><span @click="logoutInternal()">Logout & Back to DigiApp</span></div>
      </div>
    </div>
  </div>
</template>

<script>

import { mapActions } from 'pinia'
import { useAuthStore } from '../store/auth-internal';

export default {
  name: "InternalMenu",
  data() {
    return {
      activeMenu: 1,
    }
  },
  props: {
    isMenuOpen: {
      type: Boolean,
      required: false,
    },
  },
  mounted() {
    this.loadMenu()
  },
  methods: {
    ...mapActions(useAuthStore, { logout: 'logUserInternalOut' }),
    loadMenu() {
      const url = this.$route.path;
      const menu = url.split(/[/ ]+/).pop();
      switch(menu) {
        case 'dashboard': this.activeMenu = 1; break; 
        case 'attendances': this.activeMenu = 2; break; 
        case 'leave-request': this.activeMenu = 3; break; 
        case 'medical': this.activeMenu = 4; break; 
        case 'stakeholder': this.activeMenu = 5; break; 
        case 'profile': this.activeMenu = 6; break; 
        // case 'our-website': this.activeMenu = 7; break; 
        // case 'event-section': this.activeMenu = 8; break; 
      }
    },
    closeMenu() {
      this.$emit('close-menu');
    },
    changePage(id, page) {
      this.activeMenu = id;
      this.$emit('close-menu');
      setTimeout(()=>{
        navigateTo(page)
      }, 200);
    },
    changeMenu(id) {
      this.activeMenu = id
    },
    logoutInternal() {
      this.logout()
      this.$router.push('/internal/login')
    },
  }
};
</script>

<style>
  .c-menu {
    left: -100%;
    transition: all 0.3s ease-in-out;
  }

  .c-menu--open {
    left: 0;
  }
</style>