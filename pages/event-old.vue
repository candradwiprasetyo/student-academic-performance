<script lang="ts" setup>
  // definePageMeta({
  //   middleware: 'auth-event' // this should match the name of the file inside the middleware directory 
  // })
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
        name: '',
        email: '',
        member_id: 1,
      },
      validation: {
        emptyName: false,
        emptyEmail: false,
      },
      isButtonEnabled: false,
      isWrongData: false
    }
  },
  mounted() {
    this.loadEvent()
    this.loadMember()
  },
  methods: {
    async register() {
      this.validation.emptyName = false
      this.validation.emptyEmail = false
      if (this.registration.name === '' || this.registration.email === '') {
        if (this.registration.name === '') { 
          this.validation.emptyName = true
        }
        if (this.registration.email === '') { 
          this.validation.emptyEmail = true
        }
      } else {
        const { authenticateUser } = useAuthEventStore(); // use auth store
        const { authenticated } = storeToRefs(useAuthEventStore()); 
        let dataRegistration = {
          event_att_name: this.registration.name,
          event_att_email: this.registration.email,
          event_id: this.dataEvent.id,
          member_id: this.registration.member_id
        }

        await authenticateUser(dataRegistration)
        if (authenticated.value) {
          this.$router.push('/event-logged')
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
      this.validation.emptyName = (this.registration.name) ? false : true
      this.validation.emptyEmail = (this.registration.email) ? false : true

      if (
        this.registration.name &&
        this.registration.email
      ) {
        this.isButtonEnabled = true
      } else {
        this.isButtonEnabled = false
      }
    },
  },
  watch: {
    'registration.name' : function(val) { this.formChanged() },
    'registration.email' : function(val) { this.formChanged() },
  }
}
</script>

<template>
  <div>
    <Head>
      <Meta https-equiv="Content-Security-Policy" content="default-src *;" />
    </Head>
    <div class="w-full h-screen md:flex">
      <div class="flex-1 bg-cover bg-center bg-primary content-center flex items-center w-full min-h-[200px] relative">
        <div class="absolute inset-0 bg-green-500 opacity-20"></div>
        <div class="mt-14 md:mt-0 mb-10 md:mb-0 md:mx-auto mx-8 w-full md:w-[420px] border-white border-2 py-2 md:py-6 px-2 md:px-4 rounded-2xl bg-gradient-1 font-medium backdrop-blur flex md:inline gap-4 cursor-pointer" @click="openPopupDetail" v-if="!isNoEvent" >
          <!-- <div class="text-sm text-green-1 mb-2 hidden md:inline">Current Event</div> -->
          <div class="mx-auto w-24 md:w-auto flex-none">
            <img
              src="~/assets/images/event-3.jpg?v=2"
              class="mx-auto rounded-lg"
              alt="Event"
            />
          </div>
          <div class="md:mt-4 flex-grow">
            <div class="text-sm md:text-base font-black font-montserrat text-white text-border-1 capitalize">{{ dataEvent.event_title }}</div>
            <div class="text-green-1 text-2xs md:text-sm">
              <div class="mt-0 md:mt-2">{{ $dayjs(dataEvent.event_start).format('dddd, D MMMM YYYY') }}</div>
              <div class="mt-0 md:mt-2">{{ $formatHour(dataEvent.event_start) }} WIB - End</div>
              <div class="mt-0 md:mt-2 capitalize"> At {{ dataEvent.event_location }}</div>
            </div>
          </div>
        </div>
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
          <!-- <iframe src=" " style="width:100%; height:500px;" frameborder="0"></iframe> -->

          <!-- <div>test</div>

          <iframe :src="`https://docs.google.com/gview?url=${encodeURIComponent('https://stag-fe.cpopcdigiapp.org/documents/Agenda-6_SOM-26_2023.pdf')}&embedded=true`" style="width:100%; height:500px;"></iframe> -->

          <ClientOnly>
            <VuePdfEmbed :source="`https://stag-fe.cpopcdigiapp.org/documents/Agenda-6_SOM-26_2023.pdf`" />
          </ClientOnly>

          <div v-if="!isNoEvent">
            <div class="text-xl md:text-2xl font-extrabold font-montserrat">Welcome to Event Section</div>
            <div class="mt-2 md:mt-5 text-primary-1">
              <div class="text-sm">User Name</div>
              <input
                v-model="registration.name"
                type="text"
                placeholder="Enter name here"
                name="name"
                class="w-full text-xs rounded-lg py-2 px-4"
                :class="(validation.emptyName) ? 'border-red-2' : 'border-primary-3'"
                required
              />
            </div>
            <div class="mt-5 text-primary-1">
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
            <div class="mt-5 text-primary-1">
              <div class="text-sm">Country</div>
              <select class="w-full text-xs rounded-lg py-2 px-4 border-primary-3 default-select" placeholder="Select your country" v-model="registration.member_id">
                <option v-for="member in dataMember" :key="member.id" :value="member.id">{{ member.member_name }}</option>
              </select>
            </div>
            <div class="mt-5">
              <NuxtLink to="/event-logged">
                <button 
                @click.prevent="register" 
                class=" text-center w-full py-3 text-white font-bold rounded-lg"
                :class="isButtonEnabled ? 'bg-green-2' : 'bg-gray-300'"
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
        @close-popup="closePopupDetail"
        v-if="isPopupDetail"
      />
    </div>
  </div>
</template>

