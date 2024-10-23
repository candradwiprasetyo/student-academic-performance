<template>
  <div>
    <div class="rounded-lg p-8 bg-white shadow">
      <div class="flex justify-between">
        <div class="font-black text-lg">Event Page</div>
        <NuxtLink to="add-event">
          <div class="bg-green-2 rounded-lg	py-2 px-4 text-white font-bold items-center flex gap-2 text-sm ">
            <img
              src="~/assets/images/event.svg"
              class="mx-auto w-6 h-6 inline-block flex-none"
              alt="event menu"
            />
            <span class="flex-grow">Add New Event</span>
          </div>
        </NuxtLink>
      </div>
      <div class="border-primary-4 rounded-lg mt-4">
        <table class="w-full">
          <tr class="text-xs md:text-sm text-left border-b-2 border-gray-100 font-black">
            <th width="40%" class="p-2 px-2 md:px-4">Event Name</th>
            <th width="15%" class="p-2 px-2 md:px-4">Event Time</th>
            <th width="12%" class="p-2 px-2 md:px-4">Published Status</th>
            <th width="12%" class="p-2 px-2 md:px-4">Event Status</th>
            <th width="10%" class="p-2 px-2 md:px-4"></th>
          </tr>
          <tr v-if="isLoading==true">
            <td colspan="5" class="text-center py-5" >Mengambil data...</td>
          </tr>
          <tr class="text-2xs md:text-xs border-b-2 border-gray-100" v-for="event in dataEvent" :key="event.id" v-if="isLoading==false">
            <td class="py-3 md:py-2 px-1 md:px-4">
              <div class="flex gap-2">
                <div class="flex-none h-8 w-14">
                  <a :href="`event-detail/${event.id}`">
                    <img
                      :src="event.url_img"
                      class="w-auto"
                      alt="event"
                    />
                  </a>
                </div>
                <div class="flex-grow"><a :href="`event-detail/${event.id}`">{{ event.event_title  }}</a></div>
              </div>
            </td>
            <td class="py-3 md:py-2 px-1 md:px-4">{{ $dayjs(event.event_start).format('D MMMM YYYY hh:mm') + ' - ' + $dayjs(event.event_end).format('hh:mm')   }}</td>
            <td class="py-3 md:py-2 px-1 md:px-4">
              <div 
                class="rounded-lg p-[6px] pl-0 text-sm font-bold w-36 text-center cursor-pointer" 
                :class="(event.event_publish==1) ? 'bg-green-4 text-green-2 border-green-2' : 'bg-red-3 text-red-2 border-red-2'"
                @click="confirmPublishedStatus(event.id, event.event_publish)"
              >
                <img
                  :src="`images/${(event.event_publish==1) ? 'check' : 'cross'}.svg`"
                  class="mx-auto inline-block mr-1"
                  alt="check"
                  width="16"
                  height="16"
                />
                {{ event.event_publish==1 ? 'Published' : 'Unpublished' }}
              </div>
            </td>
            <td class="py-3 md:py-2 px-1 md:px-4">
              <div 
                class="rounded-lg p-[6px] pl-0 text-sm font-bold w-36 text-center cursor-pointer" 
                :class="(event.event_status==1) ? 'bg-green-4 text-green-2 border-green-2' : 'bg-red-3 text-red-2 border-red-2'"
                @click="confirmEventStatus(event.id, event.event_status)"
              >
                <img
                  :src="`images/${(event.event_status==1) ? 'check' : 'cross'}.svg`"
                  class="mx-auto inline-block mr-1"
                  alt="check"
                  width="16"
                  height="16"
                />
                {{ event.event_status==1 ? 'Active' : 'Inactive' }}
              </div>
            </td>
            <td class="py-3 md:py-2 px-1 md:px-4 text-right">
              <a :href="`event-detail/${event.id}`">
                <img
                  src="~/assets/images/eye.svg"
                  class="mx-auto inline-block cursor-pointer ml-2"
                  alt="Detail"
                  width="32"
                  height="32"
                />
              </a>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <AdminPopup
      :title="'Delete Event Confirmation'"
      :message="'Are you sure you want to delete this event?'"
      :eventName="deletedEvent.title"
      :eventTime="deletedEvent.time"
      :type="'popup-delete-event'"
      :buttonText="'Delete Event'"
      @close-popup="togglePopupDeleteEvent"
      @action="deleteEvent"
      v-if="isPopupDeleteEvent"
    />
    <AdminPopup
      :title="`${(selectedPublishedStatus.status)==1 ? 'Unpublish' : 'Publish'} event`"
      :message="`Are you sure you want to ${(selectedPublishedStatus.status)==1 ? 'unpublish' : 'publish'} this event?`"
      :type="'popup-unpublish-event'"
      :buttonText="`${(selectedPublishedStatus.status)==1 ? 'Unpublish' : 'Publish'} Event`"
      @close-popup="togglePopupPublishedStatus"
      @action="changePublishedStatus"
      v-if="isPopupPublishedStatus"
    />
    <AdminPopup
      :title="`${(selectedEventStatus.status)==1 ? 'Inactivate' : 'Activate'} event`"
      :message="`Are you sure you want to  ${(selectedEventStatus.status)==1 ? 'inactivate' : 'activate'} this event?`"
      :type="'popup-inactive-event'"
      :buttonText="`${(selectedEventStatus.status)==1 ? 'Inactivate' : 'Activate'} Event`"
      @close-popup="togglePopupEventStatus"
      @action="changeEventStatus"
      v-if="isPopupEventStatus"
    />
  </div>
</template>

<script lang="ts">
definePageMeta({
  layout: 'admin',
  middleware: 'auth' // this should match the name of the file inside the middleware directory 
})

const config = useRuntimeConfig()

export default {
  name: "Homepage",
  data() {
    return {
      isLoading: true,
      dataEvent: [],
      isPopupDeleteEvent: false,
      isPopupPublishedStatus: false,
      isPopupEventStatus: false,
      deletedEvent: {
        id: '',
        title: '',
        time: '',
      },
      selectedPublishedStatus: {
        id: '',
        status: ''
      },
      selectedEventStatus: {
        id: '',
        status: ''
      }
    }
  },
  mounted() {
    // this.loadEvent()
    // this.redirectEvent()
  },
  methods: {
    redirectEvent() {
      this.$router.push('/event')
    },
    confirmDeleteEvent(id, title, start, end) {
      this.deletedEvent.id = id
      this.deletedEvent.title = title
      this.deletedEvent.time = this.$dayjs(start).format('D MMMM YYYY hh:mm') + ' - ' + this.$dayjs(end).format('hh:mm') 
      this.togglePopupDeleteEvent()
    },
    async loadEvent() {
      const dataEvent = await fetch(config.public.baseURL + '/event?limit=1000').then(res => res.json())
      if ( dataEvent?.data.data.length > 0) {
        this.dataEvent = dataEvent.data.data
      }
      this.isLoading = false
    },
    togglePopupDeleteEvent() {
      this.isPopupDeleteEvent = !this.isPopupDeleteEvent
    },
    togglePopupPublishedStatus(){
      this.isPopupPublishedStatus = !this.isPopupPublishedStatus
    },
    togglePopupEventStatus(){
      this.isPopupEventStatus = !this.isPopupEventStatus
    },
    confirmPublishedStatus(id, status) {
      this.selectedPublishedStatus.id = id
      this.selectedPublishedStatus.status = status
      this.togglePopupPublishedStatus()
    },
    confirmEventStatus(id, status) {
      this.selectedEventStatus.id = id
      this.selectedEventStatus.status = status
      this.togglePopupEventStatus()
    },
    async deleteEvent() {
      await fetch(config.public.baseURL + '/event/' + this.deletedEvent.id, {
        method: 'DELETE'
      })
      this.togglePopupDeleteEvent()
      this.loadEvent()
    },
    async changePublishedStatus() {
      await fetch(config.public.baseURL + '/event/status_publish/' + this.selectedPublishedStatus.id, {
        method: 'GET'
      })
      this.togglePopupPublishedStatus()
      this.loadEvent()
    },
    async changeEventStatus() {
      await fetch(config.public.baseURL + '/event/status_event/' + this.selectedEventStatus.id, {
        method: 'GET'
      })
      this.togglePopupEventStatus()
      this.loadEvent()
    },
  }
}
</script>