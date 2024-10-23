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
      isKeywordWrong: false,
      selectedAgendaIndex: {
        indexRundown: '',
        indexAgenda: '',
      },
      interval:null,
    }
  },
  mounted() {
    this.loadUser()
  },
  computed:{
    sortedDataAgenda1() {
      return this.dataRundown[0].agenda.map(item=>item).sort((a,b)=> a.agenda_order - b.agenda_order)
    },
    sortedDataAgenda2() {
      return this.dataRundown[1].agenda.map(item=>item).sort((a,b)=> a.agenda_order - b.agenda_order)
    }
  },
  methods: {
    ...mapActions(useAuthEventStore, { logout: 'logoutEvent' }),
    async loadEvent(participant) {
      const dataEvent = await fetch(config.public.baseURL + '/event?status=1').then(res => res.json())
      if ( dataEvent.data.data.length > 0) {
        this.dataEvent = dataEvent.data.data[0]
        this.loadAgenda(this.dataEvent.id, participant)
      } 
    },
    async loadAgendaRealtime(eventId, participant) {
      const data = await fetch(config.public.baseURL + '/event/' + eventId).then(res => res.json())
      this.dataRundown = data.data.agenda_type
      this.dataRundown[0].expand =  true
      this.dataRundown[1].expand =  true

      if (participant?.member?.member_type_id!=1) {
        this.dataRundown.splice(1, 1);
      }

      if (agendaLocked.value === 1) {
        this.dataRundown[1].agenda_type_keyword = ''
      }

      // unlock session 2
      this.dataRundown[1].agenda_type_keyword = ''
      this.dataRundown[1].expand = true
      agendaLocked.value = 1
    },
    async loadAgenda(eventId, participant) {
      const data = await fetch(config.public.baseURL + '/event/' + eventId).then(res => res.json())
      this.dataRundown = data.data.agenda_type
      this.dataRundown[0].expand =  true
      this.dataRundown[1].expand =  true
      this.dataRundown[2].expand = true
      this.dataRundown[3].expand = true
      this.dataRundown[4].expand = true
      this.dataRundown[5].expand = true


      if (participant?.member?.member_type_id!=1) {
        this.dataRundown.splice(1, 1);
      }

      if (agendaLocked.value === 1) {
        this.dataRundown[1].agenda_type_keyword = ''
      }

      // unlock session 2
      this.dataRundown[1].agenda_type_keyword = ''
      this.dataRundown[1].expand = true
      agendaLocked.value = 1

      this.interval = setInterval(() =>{
        this.loadAgendaRealtime(eventId, participant)
      },
      10000)
    },
    loadUser() {
      const registration = useCookie('registration')
      this.dataParticipant = registration.value.data
      console.log(this.dataParticipant)

      this.loadEvent(registration.value.data)
    },
    toggleRundown(index) {
      if (this.dataRundown[index].agenda_type_keyword === '') {
        this.dataRundown[index].expand = !this.dataRundown[index].expand
      } else {
        this.isPopupLocked = true
      }
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
    openPopupAgenda(indexRundown, agendaId, type) {
      let realIindex = ''
      if (type==1) {
        realIindex = this.dataRundown[0].agenda.findIndex(item => item.id === agendaId)
      } else {
        realIindex = this.dataRundown[1].agenda.findIndex(item => item.id === agendaId)
      }
      if (this.dataRundown[indexRundown].agenda[realIindex].agenda_document.length > 0) {
        this.isPopupAgenda = true
        this.selectedAgendaIndex.indexRundown = indexRundown
        this.selectedAgendaIndex.indexAgenda = realIindex
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
    <div class="w-full min-h-screen bg-cover relative bg-green-own fixed">
      <div class="fixed inset-0 bg-green-own bg-no-repeat bg-cover" :style="{ backgroundImage: `url(${dataEvent.url_img})` }"></div>
      <div class="fixed inset-0 bg-green-own opacity-80"></div>
      <div class="absolute mx-auto left-0 right-0">
        <div class="px-8 w-full lg:w-[900px] xl:w-[1200px] md:mx-auto py-12 md:py-16 z-30">
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
                <!-- <div class="flex-none">
                  <img
                    :src="`/flag/${dataParticipant?.member?.id}.png`"
                    class="mx-auto w-8 md:w-10 h-8 md:h-10 rounded-lg"
                    alt="Logo square"
                  />
                </div>
                <div class="flex-none text-white">
                  <div class="text-xs md:text-base font-black mt-[2px] md:-mt-1 capitalize">{{ dataParticipant?.event_att_name }}</div>
                  <div class="font-medium text-2xs md:text-sm">{{ dataParticipant?.member?.member_name }}, {{ dataParticipant?.member?.member_type?.member_type_name }}</div>
                </div> -->
                <div class="flex-none text-white">
                  <div class="text-xs md:text-base font-black mt-[2px] md:-mt-1 capitalize">3rd SVOC</div>
                  <div class="font-medium text-2xs md:text-sm">Participant </div>
                </div>
              </div>
            </div>
            <div class="flex-1">
              <img
                src="~/assets/images/logout.svg"
                class="mx-auto float-right w-8 md:w-9 h-8 md:h-9 cursor-pointer"
                alt="Logout"
                @click="togglePopupLogout"
              />
            </div>
          </div>
          <div class="mb-4">
            <div class="border-white border-2 py-2 md:py-4 px-2 md:px-4 rounded-lg bg-gradient-1 font-medium backdrop-blur md:flex gap-4 cursor-pointer shadow-lg" @click="openPopupDetail">
              <div class="mx-auto w-full md:w-64 flex-none mb-5 md:mb-0">
                <img
                  :src="dataEvent.url_img"
                  class="mx-auto cursor-pointer rounded"
                  alt="Event"
                />
              </div>
              <div class="flex-grow">
                <div class="text-sm md:text-lg font-extrabold font-montserrat text-white text-border-1 -mt-1">{{ dataEvent.event_title }}</div>
                <div class="text-green-1 text-xs md:text-base">
                  <div class="mt-0 md:mt-2">{{ $dayjs(dataEvent.event_start).format('dddd, D MMMM YYYY') }}</div>
                  <div class="mt-0 md:mt-2">{{ $formatHour(dataEvent.event_start) }} - {{ $formatHour(dataEvent.event_end) }}</div>
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
                  <!-- <span class="text-red-2 font-medium" v-if="rundown.agenda_type_keyword">(Member Only)</span> -->
                </div>
                <div class="flex-none">
                  <div v-if="rundown.agenda_type_keyword">
                    <img
                      src="~/assets/images/lock.svg"
                      class="mx-auto w-6 md:w-8 h-6 md:h-8"
                      alt="Expand"
                    />
                  </div>
                  <div v-else>
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
                  <tr class="text-xs md:text-lg text-left border-b-2 border-gray-100 font-black">
                    <th width="5%" class="p-4 px-2 md:px-4"></th>
                    <th width="20%" class="p-4 px-2 md:px-4">Scheduled Time</th>
                    <th width="65%" class="p-4 px-2 md:px-4">Agenda</th>
                    <th width="10%" class="p-4 px-2 md:px-4"></th>
                  </tr>
                  <tr class="text-xs md:text-base border-b-2 border-gray-100 cursor-pointer " v-for="agenda, indexAgenda in rundown.agenda" :key="agenda.id" @click="openPopupAgenda(indexRundown, agenda.id, 1)" :class="agenda.status===1 ? 'bg-yellow-50' : ''">
                    <td class="py-3 md:py-4 px-1 md:px-4 text-center">
                      <!-- <div class="mx-auto w-3 h-3 rounded-full bg-green-500 animate-pulse" v-if="agenda.status===1"></div> -->
                      <span class="relative flex h-3 w-3" v-if="agenda.status==1">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                      </span>
                    </td>
                    <td class="py-3 md:py-4 px-1 md:px-4">{{ agenda.agenda_start_time.substring(0, 5) }} - {{ agenda.agenda_end_time.substring(0, 5) }}</td>
                    <td class="py-3 md:py-4 px-1 md:px-4">{{ agenda.agenda_name }}</td>
                    <td class="py-3 md:py-2 px-1 md:px-4 table-cell">
                      <img
                        src="~/assets/images/eye.svg"
                        class="mx-auto float-right inline-block cursor-pointer"
                        alt="Detail"
                        width="32"
                        height="32"
                        v-if="agenda?.agenda_document.length > 0"
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
    </div>
  </div>
</template>

