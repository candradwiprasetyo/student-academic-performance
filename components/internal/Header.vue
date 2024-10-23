<template>
  <div>
    <div class="px-6">
      <div class="h-16 justify-between flex items-center">
        <div class="w-auto flex items-center gap-4" @click="triggerMenu">
          <img
            src="~/assets/images/menu.svg"
            class="mx-auto"
            alt="Logo"
            width="32"
            height="32"
          />
          <div class="text-base font-extrabold capitalize">{{ title }}</div>
        </div>
        <div class="w-auto flex gap-2">
          <NuxtLink to="/internal/profile">
            <img
              src="~/assets/images/profile.svg"
              class="mx-auto"
              alt="Profile"
              width="32"
              height="32"
            />
          </NuxtLink>
          <img
            src="~/assets/images/arrow-up.svg"
            class="mx-auto"
            alt="Arrow up"
            width="32"
            height="32"
            @click="triggerExpand"
            v-if="isHeaderOpen"
          />
          <img
            src="~/assets/images/arrow-down.svg"
            class="mx-auto"
            alt="Arrow down"
            width="32"
            height="32"
            @click="triggerExpand"
            v-if="!isHeaderOpen"
          />
        </div>
      </div>
      <div class="mt-2 mb-8" v-if="isHeaderOpen">
        <div class="text-3xl font-extrabold">Hi, {{ this.dataUser.name }}</div>
        <div class="mt-4 flex gap-2 text-sm" v-if="dataAttendance?.check_in">
          <div 
            class=" text-center py-2 rounded-lg text-green-2 w-1/2"
            :class="dataAttendance?.status==1?'bg-orange-3':'bg-green-4'"
          >
            <span class="font-bold">{{ (dataAttendance?.status==1)?'Late ':'Check In ' }} </span>{{ dataAttendance.check_in }}
          </div>
          <div class="w-1/2">
            <div 
              class=" text-center w-full py-2 text-primary-3 font-bold rounded-lg bg-primary-4" v-if="!dataAttendance.check_out"
            >
              Not yet Check Out
            </div>
            <div 
              class=" text-center w-full py-2 rounded-lg bg-red-3 text-red-2" v-else
            >
              <span class="font-bold">Check Out </span>{{ dataAttendance.check_out }}
            </div>
          </div>
        </div>
        <div class="mt-4 flex" v-else>
          <div 
            class=" text-center w-full py-2 text-primary-3 font-bold rounded-lg bg-primary-4 text-xs"
          >
            Not yet Check In
          </div>
        </div>
        <div class="mt-2">
          <button
            class=" text-center w-full py-3 text-white font-bold rounded-lg bg-green-2"
            @click="triggerModalCheckin"
            v-if="!dataAttendance?.check_in"
          >
            Check In
          </button>
          <button
            class=" text-center w-full py-3 text-white font-bold rounded-lg bg-red-2"
            @click="triggerModalCheckout"
            v-else-if="!dataAttendance?.check_out"
          >
            Check Out
          </button>
          <div class="bg-primary-3 text-center w-full py-3 text-white font-bold rounded-lg" v-else-if="dataAttendance?.check_in && dataAttendance?.check_out">Thanks for your hard work !!</div>
        </div>
      </div>
    </div>
    <InternalMenu 
      :isMenuOpen="isMenuOpen"
      @close-menu="triggerMenu" 
    />
    <InternalModalCheckin
      :isModalCheckinOpen="isModalCheckinOpen"
      @close-modal-checkin="triggerModalCheckin"
      @check-in="checkIn"
    />
    <InternalModalCheckout
      :isModalCheckoutOpen="isModalCheckoutOpen"
      @close-modal-checkout="triggerModalCheckout"
      @check-out="checkOut"
    />
  </div>
</template>

<script lang="ts">

const config = useRuntimeConfig()

export default {
  name: "InternalHeader",
  props: {
    title: {
      type: String,
      required: false,
    },
  },
  data() {
    return {
      isMenuOpen: false,
      isHeaderOpen: false,
      isModalCheckinOpen: false,
      isModalCheckoutOpen: false,
      dataAttendance: {},
      dataUser: undefined,
      dataToken: '',
    }
  },
  mounted() {
    this.loadUser()
  },
  methods: {
    triggerMenu() {
      this.isMenuOpen = !this.isMenuOpen
    },
    triggerModalCheckin() {
      this.isModalCheckinOpen = !this.isModalCheckinOpen
    },
    triggerModalCheckout() {
      this.isModalCheckoutOpen = !this.isModalCheckoutOpen
    },
    triggerExpand() {
      this.isHeaderOpen = !this.isHeaderOpen
    },
    async loadAttendance() {
      const checkAttendance = await fetch(config.public.baseURL + '/attendance-absen', {
        headers: {
          Authorization: `Bearer ${this.dataToken}`
        }
      }).then(res => res.json())
      const dataAttendance = useCookie('data-attendance')
      if (checkAttendance.absen === true) {
        this.dataAttendance = checkAttendance.data
        if (!dataAttendance.value) {
          dataAttendance.value = checkAttendance.data
        }
      } else {
        dataAttendance.value = null;
      }
    },
    loadUser() {
      const user = useCookie('user-internal')
      const token = useCookie('token-internal')
      this.dataUser = user.value
      this.dataToken = token.value
      this.loadAttendance()
    },
    async checkIn() {
      const dataCheckin = await fetch(config.public.baseURL + '/attendance-checkin', { 
        method: 'POST',
        headers: {
          Authorization: `Bearer ${this.dataToken}`
        },
      }).then(res => res.json())
      const dataAttendance = useCookie('data-attendance')
      dataAttendance.value = dataCheckin.data
      this.dataAttendance = dataCheckin.data
    },
    async checkOut() {
      const dataCheckout = await fetch(config.public.baseURL + '/attendance-checkout', {
        method: 'POST',
        headers: {
          Authorization: `Bearer ${this.dataToken}`
        }
      }).then(res => res.json())
      const dataAttendance = useCookie('data-attendance')
      this.dataAttendance = dataCheckout.data
      dataAttendance.value = this.dataAttendance
    },
  },
}
</script>
