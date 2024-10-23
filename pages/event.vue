<script lang="ts" setup>
  definePageMeta({
    middleware: 'auth-event' // this should match the name of the file inside the middleware directory 
  })
</script>
<script lang="ts">
import { storeToRefs } from 'pinia';
import { useAuthEventStore } from '../store/authEvent';
const config = useRuntimeConfig()

export default {
  name: "EventLogged",
  data() {
    return {
      dataEvent: {},
      dataMember: [],
      isPopupDetail: false,
      isNoEvent: false,
      registration: {
        email: '',
        password: '',
      },
      validation: {
        emptyName: false,
        emptyPassword: false,
      },
      isButtonEnabled: false,
      isWrongData: false,
      showPassword: false,
    }
  },
  mounted() {
    this.loadEvent()
    this.loadMember()
  },
  methods: {
    async register() {
      this.validation.emptyName = false
      this.validation.emptyPassword = false
      if (this.registration.password === '' || this.registration.email === '') {
        if (this.registration.password === '') { 
          this.validation.emptyPassword = true
        }
        if (this.registration.email === '') { 
          this.validation.emptyEmail = true
        }
      } else {
        const { authenticateUser } = useAuthEventStore(); // use auth store
        const { authenticated } = storeToRefs(useAuthEventStore()); 
        let dataRegistration = {
          email: this.registration.email,
          password: this.registration.password,
          event_id: this.dataEvent.id,
        }

        await authenticateUser(dataRegistration)
        if (authenticated.value) {
          this.$router.push('/event-logged')
        } else {
          this.isWrongData = true
        }
      }
    },
    async loadEvent() {
      const dataEvent = await fetch(config.public.baseURL + '/event?status=1').then(res => res.json())
      if ( dataEvent?.data.data.length > 0) {
        this.dataEvent = dataEvent.data.data[0]
      } else {
        this.isNoEvent = true
      }
    },
    async loadMember() {
      const dataMember = await fetch(config.public.baseURL + '/member').then(res => res.json())
      if ( dataMember?.data.length > 0) {
        this.dataMember = dataMember.data
      } 
    },
    closePopupDetail() {
      this.isPopupDetail = false
    },
    openPopupDetail() {
      this.isPopupDetail = true
    },
    formChanged() {
      this.validation.emptyPassword = (this.registration.password) ? false : true
      this.validation.emptyEmail = (this.registration.email) ? false : true

      if (
        this.registration.password &&
        this.registration.email
      ) {
        this.isButtonEnabled = true
      } else {
        this.isButtonEnabled = false
      }
    },
    toggleShow() {
      this.showPassword = !this.showPassword;
    }
  },
  watch: {
    'registration.password' : function(val) { this.formChanged() },
    'registration.email' : function(val) { this.formChanged() },
  }
}
</script>

<template>
  <div>
    <div class="w-full h-screen lg:flex">
      <div class="w-full lg:w-1/2 bg-center bg-cover bg-no-repeat content-center flex items-center min-h-auto md:min-h-[40vh] lg:min-h-[40vh] relative" :style="{ backgroundImage: `url(${dataEvent.url_img})` }">
        <div class="md:absolute inset-0 opacity-80 bg-green-own"></div>
        <div class="mt-0 mb-10 md:mb-0 md:mx-auto mx-auto left-0 right-0 w-full md:w-[70%] lg:w-[500px] py-2 md:py-6 px-6 md:px-4 md:rounded-2xl font-medium inline gap-4 cursor-pointer md:absolute text-white bg-no-repeat bg-cover min-h-[200px] md:min-h-[260px] md:border-4" @click="openPopupDetail" v-if="!isNoEvent" :style="{ backgroundImage: `url(${dataEvent.url_img})` }">
          <div class="absolute left-0 right-0 h-40 bottom-0 md:rounded-b-xl bg-gradient-to-t from-black to-transparent"></div>
          <div class="md:mt-4 flex-grow absolute bottom-6 ">
            <div class="text-2xl font-black font-montserrat text-white text-border-1">{{ dataEvent.event_title }}</div>
            <div class="text-white text-sm font-bold">
              <div class="mt-2">{{ $dayjs(dataEvent.event_start).format('dddd, D MMMM YYYY') }} | {{ $formatHour(dataEvent.event_start) }} - End</div>
              <div class="mt-1 capitalize">{{ dataEvent.event_location }}</div>
            </div>
          </div>
        </div>
        
      </div>
      <div class="lg:w-1/2 content-center flex items-center px-8 md:px-0 md:py-10">
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
          <div v-if="!isNoEvent">
            <div class="text-xl md:text-2xl font-extrabold font-montserrat">Welcome to Event Section</div>
            <div v-if="isWrongData" class="bg-red-500 text-white p-2 mt-4 text-xs text-center rounded">Registration failed. Wrong email or password</div>
            <div class="mt-2 md:mt-5 text-primary-1">
              <div class="text-sm">Email Address</div>
              <input
                v-model="registration.email"
                type="text"
                placeholder="Enter email here"
                name="email"
                class="w-full text-xs rounded-lg py-2 px-4"
                :class="(validation.emptyEmail) ? 'border-red-2' : 'border-primary-3'"
                required
              />
            </div>
            <div class="mt-5 text-primary-1 relative">
              <div class="text-sm">Password</div>
              <input
                v-model="registration.password"
                :type="(showPassword) ? 'text' : 'password'"
                placeholder="Enter password here"
                name="password"
                class="w-full text-xs rounded-lg py-2 px-4"
                :class="(validation.emptyPassword) ? 'border-red-2' : 'border-primary-3'"
                required
              />
              <!-- <input v-if="showPassword" type="text" class="input" v-model="password" />
              <input v-else type="password" class="input" v-model="password"> -->
              <div class="absolute right-1 bottom-1 w-7 h-7 cursor-pointer" @click="toggleShow">
                <img
                  src="~/assets/images/eye.png"
                  class="mx-auto mb-4"
                  alt="Logo"
                  width="40"
                  height="40"
                  v-if="showPassword"
                />
                <img
                  src="~/assets/images/eye-closed.png"
                  class="mx-auto mb-4"
                  alt="Logo"
                  width="40"
                  height="40"
                  v-else
                />
              </div>
            </div>
            <div class="mt-5">
              <NuxtLink to="/event-logged">
                <button 
                @click.prevent="register" 
                class=" text-center w-full py-3 text-white font-bold rounded-lg"
                :class="isButtonEnabled ? 'bg-green-own' : 'bg-gray-300'"
              >
                Enter Event
              </button>
              </NuxtLink>
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
      <PopupEvent 
        :title="dataEvent.event_title"
        :message="dataEvent.event_description"
        :time="`${$formatHour(dataEvent.event_start)} WIB - End`"
        :date="$dayjs(dataEvent.event_start).format('dddd, D MMMM YYYY')"
        :location="dataEvent.event_location"
        :urlImg="dataEvent.url_img"
        @close-popup="closePopupDetail"
        v-if="isPopupDetail"
      />
    </div>
  </div>
</template>

