<script lang="ts">
import { mapActions } from 'pinia'
import { useAuthEventStore } from '../store/authEvent';
const { $formatHour } = useNuxtApp()
const config = useRuntimeConfig()
const agendaLocked = useCookie('agenda-locked')

export default {
  name: "EventLogged",
  data() {
    return {
      dataEvent: {},
      dataRundown: [],
      dataParticipant: {},
      isPopupDetail: false,
      isPopupLocked: false,
      isPopupAgenda: false,
      isPopupLogout: false,
      isPopupChangePassword: false,
      isKeywordWrong: false,
      selectedAgendaIndex: {
        indexRundown: '',
        indexAgenda: '',
      },
      interval:null,
    }
  },
  mounted() {
    this.loadEvent()
  },
  methods: {
    ...mapActions(useAuthEventStore, { logout: 'logoutEvent' }),
    async loadEvent() {
      const dataEvent = await fetch(config.public.baseURL + '/event?status=1').then(res => res.json())
      if ( dataEvent.data.data.length > 0) {
        this.dataEvent = dataEvent.data.data[0]
        this.loadAgenda(this.dataEvent.id)
      } 
    },
    async loadAgenda(eventId) {
      const data = await fetch(config.public.baseURL + '/event/' + eventId).then(res => res.json())
      this.dataRundown = data.data.agenda_type
      this.dataRundown[0].expand =  true
    },
    loadUser() {
      const registration = useCookie('registration')
      this.dataParticipant = registration.value.data

      this.loadEvent(registration.value.data)
    },
    toggleRundown(index) {
      this.dataRundown[index].expand = !this.dataRundown[index].expand
    },
    closePopupDetail() {
      this.isPopupDetail = false
    },
    openPopupDetail() {
      this.isPopupDetail = true
    },
    closePopupLocked() {
      this.isPopupLocked = false
    },
    openPopupLocked() {
      this.isPopupLocked = true
    },
    closePopupAgenda() {
      this.isPopupAgenda = false
    },
    togglePopupChangePassword() {
      this.isPopupChangePassword = !this.isPopupChangePassword
    },
    openPopupAgenda(indexRundown, indexAgenda) {
      if (this.dataRundown[indexRundown].agenda[indexAgenda].agenda_document.length > 0) {
        this.isPopupAgenda = true
        this.selectedAgendaIndex.indexRundown = indexRundown
        this.selectedAgendaIndex.indexAgenda = indexAgenda
      }
    },
    openRundown(keyword) {
      if (keyword === this.dataRundown[1].agenda_type_keyword) {
        this.isKeywordWrong = false
        this.isPopupLocked = false
        this.dataRundown[1].agenda_type_keyword = ''
        this.dataRundown[1].expand = true
        agendaLocked.value = 1
      } else {
        this.isKeywordWrong = true
      }
    },
    togglePopupLogout() {
      this.isPopupLogout = !this.isPopupLogout
    },
    clickLogout() {
      this.logout()
      this.$router.push('/event')
    },
  }
}
</script>

<template>
  <div>
    <Head>
      <Meta https-equiv="Content-Security-Policy" content="default-src *;" />
    </Head>
    <div class="w-full min-h-screen bg-cover bg-primary relative">
      <!-- <div class="absolute inset-0 bg-green-500 opacity-30 z-20"></div> -->
      <div>
        <div class="px-4 w-full lg:w-[900px] xl:w-[1200px] md:mx-auto py-6 md:py-16 z-30">
          <div class="flex mb-4 md:mb-8">
            <div class="flex-1">
              <div class="flex gap-2">
                <div class="flex-none">
                  <img
                    src="~/assets/images/logo-square.svg"
                    class="mx-auto w-8 md:w-10 h-8 md:h-10"
                    alt="Logo square"
                  />
                </div>
                <div class="flex-none items-center flex">
                  <div class="text-xs md:text-base font-black mt-[2px] md:-mt-1 capitalize">Council of Palm Oil Producing Countries (CPOPC)</div>
                </div>
              </div>
            </div>
          </div>
          <div class="mb-4">
            <div class="border-white border-2 py-2 md:py-4 px-2 md:px-4 rounded-lg bg-gradient-1 font-medium backdrop-blur md:flex gap-4 cursor-pointer shadow-lg" @click="openPopupDetail">
              <div class="mx-auto w-full md:w-64 flex-none mb-6">
                <img
                  :src="dataEvent.url_img"
                  class="mx-auto cursor-pointer rounded"
                  alt="Event"
                />
              </div>
              <div class="flex-grow">
                <div class="text-sm md:text-lg font-extrabold font-montserrat text-white text-border-1 my-2">{{ dataEvent.event_title }}</div>
                <div class="text-green-1 text-sm md:text-base">
                  <div class="mt-0 md:mt-2">{{ $dayjs(dataEvent.event_start).format('dddd, D MMMM YYYY') }}</div>
                  <div class="mt-0 md:mt-2">{{ $formatHour(dataEvent.event_start) }} WIB - {{ $formatHour(dataEvent.event_end) }} WIB</div>
                  <div class="mt-0 md:mt-2 capitalize"> {{ dataEvent.event_location }}</div>
                </div>
              </div>
            </div>
          </div>
          <div class="bg-white rounded-lg mb-4" v-for="rundown, indexRundown in dataRundown" :key="rundown.id">
            <!-- {{ dataParticipant?.member?.member_type_id + '-' + indexRundown  }} -->
            <div class="py-2 px-2 md:px-4">
              <div class="flex cursor-pointer items-center" @click="toggleRundown(indexRundown)">
                <div class="text-sm md:text-xl font-extrabold text-green-1 flex-grow font-montserrat align-center">
                  {{ rundown.agenda_type_name }}
                </div>
                <div class="flex-none">
                  <div>
                    <img
                      src="~/assets/images/arrow-down.svg"
                      class="mx-auto w-6 md:w-8 h-6 md:h-8"
                      alt="Expand"
                      v-if="rundown.expand === false"
                    />
                    <img
                      src="~/assets/images/arrow-up.svg"
                      class="mx-auto w-6 md:w-8 h-6 md:h-8"
                      alt="Close"
                      v-else
                    />
                  </div>
                </div>
              </div>
              <div class="w-full border-primary-4 rounded-lg mb-2 mt-4" v-if="rundown.expand===true">
                <table class="w-full">
                  <tr class="text-sm md:text-lg text-left border-b-2 border-gray-100 font-black">
                    <th width="5%" class="p-4 px-2 md:px-4"></th>
                    <th width="20%" class="p-4 px-2 md:px-4">Scheduled Time</th>
                    <th width="65%" class="p-4 px-2 md:px-4">Agenda</th>
                    <th width="10%" class="p-4 px-2 md:px-4 hidden md:inline"></th>
                  </tr>
                  <tr class="text-sm md:text-base border-b-2 border-gray-100 cursor-pointer " v-for="agenda, indexAgenda in rundown.agenda" :key="agenda.id" @click="openPopupAgenda(indexRundown, indexAgenda)" :class="agenda.status==1 ? 'bg-yellow-50' : ''">
                    <td class="py-3 md:py-4 px-1 md:px-4 text-center">
                      <!-- <div class="mx-auto w-3 h-3 rounded-full bg-green-500 animate-pulse" v-if="agenda.id===1"></div> -->
                      <span class="relative flex h-3 w-3" v-if="agenda.status==1">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                      </span>
                    </td>
                    <td class="py-3 md:py-4 px-1 md:px-4">{{ (agenda.agenda_start_time) ? agenda.agenda_start_time.substring(0, 5) + '-' + agenda.agenda_end_time.substring(0, 5) : '-' }}</td>
                    <td class="py-3 md:py-4 px-1 md:px-4">{{ agenda.agenda_name }}</td>
                    <td class="py-3 md:py-2 px-1 md:px-4 hidden md:table-cell">
                      <img
                        src="~/assets/images/eye.svg"
                        class="mx-auto float-right inline-block cursor-pointer"
                        alt="Detail"
                        width="32"
                        height="32"
                        v-if="dataRundown[indexRundown].agenda[indexAgenda].agenda_document.length > 0"
                      />
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
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
      <PopupLocked 
        :isKeywordWrong="isKeywordWrong"
        @close-popup="closePopupLocked"
        @open-rundown="openRundown"
        v-if="isPopupLocked"
      />
      <PopupAgenda
        :dataRundown="dataRundown"
        :selectedAgendaIndex="selectedAgendaIndex"
        :typeMember="dataParticipant?.member?.member_type?.id"
        @close-popup="closePopupAgenda"
        v-if="isPopupAgenda"
      />
      <AdminPopup
        :title="'Logout'"
        :message="'Are you sure you want to logout?'"
        :type="'popup-logout'"
        :buttonText="'Logout'"
        @close-popup="togglePopupLogout"
        @action="clickLogout"
        v-if="isPopupLogout"
      />
      <PopupChangePassword
        :participantId="dataParticipant.participant.id"
        :participantName="dataParticipant.participant.participant_name"
        :participantEmail="dataParticipant.participant.participant_email"
        :memberId="dataParticipant.member_id"
        @close-popup="togglePopupChangePassword"
        v-if="isPopupChangePassword"
      />
    </div>
  </div>
</template>

