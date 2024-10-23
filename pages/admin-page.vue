
<template>
  <div>
    <div class="w-full h-screen md:flex">
      <div class="flex-1 bg-cover bg-center bg-primary content-center flex items-center w-full min-h-[200px]">
        
      </div>
      <div class="flex-1 content-center flex items-center px-8 md:px-0">
        <div class="w-full md:w-[296px] mx-auto font-medium py-8 md:py-0">
          <div class="hidden md:inline">
            <img
              src="~/assets/images/logo-cpopc.svg"
              class="mx-auto mb-4"
              alt="Logo"
              width="128"
              height="128"
            />
          </div>
          <div v-if="true">
            <div class="text-xl md:text-2xl font-extrabold font-montserrat">Welcome to Member Section</div>
            <div v-if="isWrongData" class="bg-red-500 text-white p-2 mt-4 text-xs text-center rounded">Login failed. Wrong email or password</div>
            <div class="mt-2 md:mt-5 text-primary-1">
              <div class="text-sm">Email</div>
              <input
                v-model="user.email"
                type="text"
                placeholder="Enter email here"
                name="email"
                class="w-full text-xs rounded-lg py-2 px-4 "
                :class="(validation.emptyEmail) ? 'border-red-2' : 'border-primary-3'"
                required
              />
              <div class="text-2xs text-red-2 mt-1" v-if="validation.emptyEmail">This field is required to login</div>
            </div>
            <div class="mt-5 text-primary-1">
              <div class="text-sm">Password</div>
              <input
                v-model="user.password"
                type="password"
                placeholder="Enter your password here"
                name="password"
                class="w-full text-xs rounded-lg py-2 px-4 border-primary-3"
                required
              />
              <div class="text-2xs text-red-2 mt-1" v-if="validation.emptyPassword">This field is required to login</div>
            </div>
            <div class="mt-5">
              <button 
                @click.prevent="login" 
                class=" text-center w-full py-3 text-white font-bold rounded-lg"
                :class="isButtonEnabled ? 'bg-green-2' : 'bg-gray-300'"
              >
                Enter Member Section
              </button>
            </div>
          </div>
          <div v-else>
            <div class="text-2xl font-montserrat">
              No event for today ...<br>
              But you still can <br>
              <span class="font-extrabold">explore our website !!</span>
            </div>
            <div class="mt-4">
              <a href="https://cpopc.org/" target="_blank">
                <div class="bg-green-2 text-center w-full py-3 text-white font-bold rounded-lg">
                  Explore Our Website
                </div>
              </a>
            </div>
          </div>
          <div class="mt-2 md:mt-4 text-center text-2xs font-medium">Copyright © {{ new Date().getFullYear() }} cpopc.net. All rights reserved.</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { storeToRefs } from 'pinia';
import { useAuthStore } from '../store/auth';

export default {
  name: "Admin",
  data() {
    return {
      dataEvent: {},
      isPopupDetail: false,
      isNoEvent: false,
      user: {
        email: '',
        password: '',
      },
      validation: {
        emptyEmail: false,
        emptyPassword: false,
      },
      isButtonEnabled: false,
      isWrongData: false
    }
  },
  methods: {
    async login() {
      this.validation.emptyEmail = false
      this.validation.emptyPassword = false
      if (this.user.email === '' || this.user.password === '') {
        if (this.user.email === '') { 
          this.validation.emptyEmail = true
        }
        if (this.user.password === '') { 
          this.validation.emptyPassword = true
        }
      } else {
        const { authenticateUser } = useAuthStore(); // use auth store
        const { authenticated } = storeToRefs(useAuthStore()); 
        await authenticateUser(this.user);

        if (authenticated.value) {
          this.$router.push('/admin/event')
        } else {
          this.isWrongData = true
        }
      }
    },
    closePopupDetail() {
      this.isPopupDetail = false
    },
    openPopupDetail() {
      this.isPopupDetail = true
    },
    formChanged() {
      this.validation.emptyEmail = (this.user.email) ? false : true
      this.validation.emptyPassword = (this.user.password) ? false : true

      if (
        this.user.email &&
        this.user.password
      ) {
        this.isButtonEnabled = true
      } else {
        this.isButtonEnabled = false
      }
    },
  },
  watch: {
    'user.email' : function(val) { this.formChanged() },
    'user.password' : function(val) { this.formChanged() },
  }
}


</script>
