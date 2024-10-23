<template>
  <div>
    <NuxtLink to="/admin/event"><button
        class="px-4 py-2 mb-4 font-bold text-center rounded-lg cursor-pointer text-green-2 bg-green-4 border-green-2">Back</button>
    </NuxtLink>
    <div class="flex p-4 bg-white rounded-lg border-primary-4">
      <div class="flex flex-grow gap-2">
        <div class="flex-none">
          <img :src="dataEvent.url_img" class="w-32 rounded-lg" alt="event" width="100" />
        </div>
        <div class="flex-grow">
          <div class="font-extrabold text-green-2 font-montserrat">{{ dataEvent.event_title }}</div>
          <div class="gap-2 my-1 text-xs text-green-1">
            <span>{{ $dayjs(dataEvent.event_start).format('dddd, D MMMM YYYY') }}</span>
            <span class="px-2">&#x2022;</span>
            <span>{{ $formatHour(dataEvent.event_start) }} WIB - End</span>
            <span class="px-2">&#x2022;</span>
            <span>{{ dataEvent.event_location }}</span>
          </div>
          <div>
            <div class="inline-block px-2 py-1 mr-2 rounded-lg bg-green-4 text-2xs text-green-1">Published</div>
            <div class="inline-block px-2 py-1 rounded-lg bg-green-4 text-2xs text-green-1">Active</div>
          </div>
        </div>
      </div>
      <div class="flex-none" v-if="dataUser.role_id==1">
        <img
          src="~/assets/images/delete.svg"
          class="inline-block mx-auto ml-2 cursor-pointer"
          alt="delete"
          width="32"
          height="32"
          @click="togglePopupDeleteEvent()"
        />
      </div>
    </div>
    <div class="flex mt-4 text-sm">
      <div class="flex-1">
        <div class="py-2 font-bold text-center rounded-lg cursor-pointer text-green-2"
          :class="activeTab == 1 ? 'bg-green-4 border-green-2' : ''" @click="changeTab(1)">Event Content</div>
      </div>
      <div class="flex-1">
        <div class="py-2 font-bold text-center rounded-lg cursor-pointer text-green-2"
          :class="activeTab == 2 ? 'bg-green-4 border-green-2' : ''" @click="changeTab(2)">Event Rundown</div>
      </div>
      <!-- <div class="flex-1">
        <div class="py-2 font-bold text-center rounded-lg cursor-pointer text-green-2"
          :class="activeTab == 3 ? 'bg-green-4 border-green-2' : ''" @click="changeTab(3)">Participant List</div>
      </div> -->
    </div>
    <div class="p-4 mt-4 bg-white rounded-lg border-primary-4">
      <div v-if="activeTab == 1" class="text-sm">
        <form @submit.prevent="saveEvent">
          <div class="mt-1">
            <div class="text-sm">Event Name</div>
            <input v-model="payload_event.eventName" type="text" placeholder="Enter your event name here" name="eventName"
              class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required />
          </div>
          <div class="flex gap-4 mt-4">
            <div class="flex-1">
              <div class="text-sm">Event Start Date</div>
              <div class="flex gap-3">
                <div class="flex-1">
                  <client-only>
                    <v-date-picker v-model="payload_event.eventStartDate">
                      <template v-slot="{ inputValue, inputEvents }">
                        <input id="input-publication-date" name="publication-date" type="text"
                          class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" :value="inputValue" v-on="inputEvents"
                          placeholder="dd/mm/yyyy" readonly />
                      </template>
                    </v-date-picker>
                  </client-only>
                </div>
                <div class="flex-1">
                  <input v-model="payload_event.eventStartDateTime" type="text" placeholder="00:00" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required />
                </div>
              </div>
              
            </div>
            <div class="flex-1">
              <div class="text-sm">Event End Date</div>
              <div class="flex gap-3">
                <div class="flex-1">
                  <client-only>
                    <v-date-picker v-model="payload_event.eventEndDate">
                      <template v-slot="{ inputValue, inputEvents }">
                        <input id="input-publication-date" name="publication-date" type="text"
                          class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" :value="inputValue" v-on="inputEvents"
                          placeholder="dd/mm/yyyy" readonly />
                      </template>
                    </v-date-picker>
                  </client-only>
                </div>
                <div class="flex-1">
                  <input v-model="payload_event.eventEndDateTime" type="text" placeholder="00:00" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required />
                </div>
              </div>
            </div>
          </div>
          <div class="mt-4">
            <div class="text-sm">Location</div>
            <input v-model="payload_event.eventLocation" type="text" placeholder="Enter your event location here"
              class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required />
          </div>
          <div class="mt-4">
            <div class="text-sm">Link Map</div>
            <input v-model="payload_event.eventLinkMap" type="text" placeholder="Enter your event link map here"
              class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required />
          </div>
          <div class="mt-4">
            <div class="text-sm">Source</div>
            <input v-model="payload_event.eventSource" type="text" placeholder="Enter your event source here"
              class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required />
          </div>
          <div class="mt-4">
            <div class="text-sm">Description</div>
            <textarea v-model="payload_event.eventDescription" placeholder="Enter your event description here"
              name="eventDescription" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required></textarea>
          </div>
          <div class="mt-4">
            <div class="text-sm">Content</div>
            <textarea v-model="payload_event.eventContent" placeholder="Enter your event content here" name="eventContent"
              class="w-full px-4 py-2 text-xs rounded-lg border-primary-3"></textarea>
          </div>
          <div class="flex gap-4 mt-4">
            <div class="flex-1">
              <div class="text-sm">Event Status</div>
              <select v-model="payload_event.eventStatus" placeholder="Enter your event status here" name="eventName"
                class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required>
                <option value="0" selected>Inactive</option>
                <option value="1">Active</option>
              </select>
            </div>
            <div class="flex-1">
              <div class="text-sm">Published Status</div>
              <select v-model="payload_event.eventPublishedStatus" placeholder="Enter your event date here"
                name="eventPublishedStatus" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required>
                <option value="0" selected>Unpublish</option>
                <option value="1">Publish</option>
              </select>
            </div>
          </div>
          <div class="mt-4">
            <div class="text-sm">Event Type</div>
            <select placeholder="Enter event type" v-model="payload_event.eventTypeId"
              name="eventTypeId" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required>
              <option value="1" selected>Public</option>
              <option value="2">Official</option>
              <option value="3">Internal</option>
            </select>
          </div>
          <div class="mt-4">
            <div class="text-sm">Image / Banner</div>
            <img :src="dataEvent.url_img" class="my-2 w-60">
            <input type="file" @change="onUploadFiles" />
            <div class="text-2xs">HD Image <span class="px-2">&#x2022;</span> Max Size : 10 Mb <span
                class="px-2">&#x2022;</span>
              Allowed File : PNG/JPG/JPEG</div>
          </div>
          <div class="flex justify-end">
            <a href="/admin/event"><button
              class="px-4 py-2 mb-4 font-bold text-center rounded-lg cursor-pointer text-green-2 bg-green-4 border-green-2">Cancel</button>
            </a>
            <button class="w-32 px-4 py-2 mb-4 ml-3 text-sm font-bold text-center text-white rounded-lg cursor-pointer bg-green-2"
              :disabled="isSubmit"
              >
              {{ isSubmit ? 'Saving...' : 'Update Event' }}
            </button>
          </div>
        </form>
      </div>
      <div v-if="activeTab == 2">
        <div v-for="rundown, indexRundown in dataRundown" :key="rundown.id">
          <div class="flex justify-between text-sm font-extrabold md:text-xl text-green-1 font-montserrat align-center">
            <div>
              {{ rundown.agenda_type_name }}
              <span class="font-medium text-red-2" v-if="rundown.agenda_type_keyword">(Member Only)</span>
            </div>
            <div class="flex gap-1">
              <div
                class="items-center px-4 py-2 text-sm font-bold text-white rounded-lg cursor-pointer bg-green-2 hover:brightness-110"
                @click="openPopupAgendaType(indexRundown)">Update Session
              </div>
              <img
                src="~/assets/images/delete.svg"
                class="ml-2 cursor-pointer"
                alt="delete"
                width="32"
                height="32"
                @click="openPopupDeleteRundown(rundown.id)"
              />
            </div>
          </div>
          <div class="w-full mt-4 mb-6 rounded-lg border-primary-4">
            <table class="w-full">
              <tr class="text-sm font-black text-left border-b-2 border-gray-100 md:text-base">
                <th width="5%" class="p-4 px-2 md:px-4"></th>
                <th width="15%" class="p-4 px-2 md:px-4">Time</th>
                <th width="45%" class="p-4 px-2 md:px-4">Agenda</th>
                <th width="15%" class="p-4 px-2 md:px-4">File</th>
                <th class="p-4 px-2 md:px-4"></th>
              </tr>
              <tr class="text-xs border-b-2 border-gray-100 cursor-pointer md:text-sm "
                v-for="agenda, indexAgenda in rundown.agenda" :key="agenda.id"
                :class="agenda.status == 1 ? 'bg-yellow-50' : ''">
                <td class="px-1 py-3 text-center md:py-4 md:px-4">
                  <!-- <div class="w-3 h-3 mx-auto bg-green-500 rounded-full animate-pulse" v-if="agenda.id===1"></div> -->
                  <span class="relative flex w-3 h-3" v-if="agenda.status == 1">
                    <span
                      class="absolute inline-flex w-full h-full bg-green-400 rounded-full opacity-75 animate-ping"></span>
                    <span class="relative inline-flex w-3 h-3 bg-green-500 rounded-full"></span>
                  </span>
                </td>
                <td class="px-1 py-3 md:py-4 md:px-4">{{ agenda.agenda_start_time.substring(0, 5) }} - {{
                agenda.agenda_end_time.substring(0, 5) }}</td>
                <td class="px-1 py-3 md:py-4 md:px-4">{{ agenda.agenda_name }}</td>
                <td class="px-1 py-3 md:py-4 md:px-4">
                  <div
                    :class="(agenda.agenda_document.length > 0) ? 'py-2 text-center text-blue-500 font-bold rounded-lg cursor-pointer bg-blue-100 text-xs px-2' : ''"
                    @click="openPopupAgenda(indexRundown, indexAgenda)
                  ">
                    {{ (agenda.agenda_document.length > 0 ? agenda.agenda_document.length + ' Documents' : '-') }}
                  </div>
                </td>
                <td class="hidden px-1 py-3 md:py-2 md:px-4 md:table-cell flex ">
                  <div class="flex justify-end">
                    <div :class="agenda.status == 1 ? 'bg-red-100' : 'bg-green-4'"
                      class="py-2 text-xs font-bold text-center rounded-lg cursor-pointer text-green-2 px-3"
                      @click="activateAgenda(agenda.id)">{{ (agenda.status == 1) ? 'Deactivate' : 'Activate' }}
                    </div>
                    <img
                      src="~/assets/images/edit.svg"
                      class="cursor-pointer ml-2"
                      alt="Edit"
                      width="32"
                      height="32"
                      @click="openPopupAgendaEdit(indexRundown, agenda.id)"
                    />
                    <img
                      src="~/assets/images/delete.svg"
                      class="ml-2 cursor-pointer"
                      alt="delete"
                      width="32"
                      height="32"
                      @click="togglePopupDeleteAgenda(agenda.id)"
                    />
                  </div>
                </td>
              </tr>
            </table>
            <div
              class="w-32 py-2 my-4 ml-4 text-sm font-bold text-center text-white rounded-lg cursor-pointer bg-green-2 hover:brightness-110"
              @click="openPopupAgendaAdd(rundown.id)">Add Agenda
            </div>
          </div>
        </div>
        <div class="flex justify-center">
          <div class="items-center px-4 py-2 text-sm font-bold text-white rounded-lg cursor-pointer bg-green-2 hover:brightness-110" @click="openPopupAgendaType(99)">Add Session
          </div>
        </div>
      </div>
        
      <!-- <div v-if="activeTab==3"></div> -->
    </div>
    <AdminPopupAgenda :dataRundown="dataRundown" :selectedAgendaIndex="selectedAgendaIndex"
      @close-popup="togglePopupAgenda" @activate-document="activateDocument" v-if="isPopupAgenda" />
    <AdminPopup :title="'Delete Event Confirmation'" :message="'Are you sure you want to delete this event?'"
      :eventName="dataEvent.event_title"
      :eventTime="$dayjs(dataEvent.event_start).format('D MMMM YYYY hh:mm') + ' - ' + $dayjs(dataEvent.event_end).format('hh:mm')"
      :type="'popup-delete-event'" :buttonText="'Delete Event'" @close-popup="togglePopupDeleteEvent"
      @action="deleteEvent" v-if="isPopupDeleteEvent" />
    <AdminPopupAgendaType :dataRundown="dataRundown" :selectedAgendaTypeIndex="selectedAgendaTypeIndex" :eventId="paramId"
      @close-popup="togglePopupAgendaType" v-if="isPopupAgendaType" />
    <AdminPopupAgendaAdd :selectedAgendaTypeIndex="selectedAgendaTypeIndex" @close-popup="togglePopupAgendaAdd"
      v-if="isPopupAgendaAdd" />
    <AdminPopupAgendaEdit :selectedAgendaData="selectedAgendaData" @close-popup="togglePopupAgendaEdit"
      v-if="isPopupAgendaEdit" @save-data="togglePopupAgendaEdit(true)" />
    <AdminPopup :title="'Success'" :message="'Event data updated successfully'"
      @close-popup="togglePopupEditSuccess"
      @action="togglePopupEditSuccess" v-if="isPopupEditSuccess"
    />
    <AdminPopup
      :title="`Delete agenda`"
      :message="`Are you sure you want to delete this data?`"
      :buttonText="`Delete agenda`"
      @close-popup="togglePopupDeleteAgenda"
      @action="deleteAgenda"
      v-if="isPopupDeleteAgenda"
    />
    <AdminPopup
      :title="`Delete rundown`"
      :message="`Are you sure you want to delete this data?`"
      :buttonText="`Delete rundown`"
      @close-popup="togglePopupDeleteRundown"
      @action="deleteRundown"
      v-if="isPopupDeleteRundown"
    />
  </div>
</template>

<script lang="ts">
definePageMeta({
  layout: 'admin',
})

const config = useRuntimeConfig()
const route = useRoute()

export default {
  name: "EventDetail",
  data() {
    return {
      dataUser: [],
      dataEvent: [],
      dataRundown: [],
      activeTab: 1,
      isPopupAgenda: false,
      isPopupDeleteEvent: false,
      isPopupAgendaType: false,
      isPopupAgendaAdd: false,
      isPopupEditSuccess: false,
      isPopupDeleteAgenda: false,
      isPopupAgendaEdit: false,
      isPopupDeleteRundown: false,
      selectedDeleteAgenda: '',
      selectedDeleteRundown: '',
      selectedAgendaTypeIndex: '',
      selectedAgendaIndex: {
        indexRundown: '',
        indexAgenda: '',
      },
      selectedAgendaData: '',
      paramId: '',
      isSubmit: false,
      payload_event: {
        eventName: '',
        eventStartDate: '',
        eventStartDateTime: '',
        eventEndDate: '',
        eventEndDateTime: '',
        eventLocation: '',
        eventDescription: '',
        eventStatus: '',
        eventPublishedStatus: '',
        eventLinkMap: '',
        eventSource: '',
        eventContent: '',
        eventFile: '',
        eventTypeId: '',
      }
    }
  },
  mounted() {
    this.paramId = this.$route.params.id
    this.loadEvent(this.paramId)
    this.loadUser()
  },
  methods: {
    loadUser() {
      const user = useCookie('user')
      this.dataUser = user.value
    },
    changeTab(id) {
      this.activeTab = id
    },
    async loadEvent(paramId) {
      const dataEvent = await fetch(config.public.baseURL + '/event/' + paramId).then(res => res.json())
      this.dataEvent = dataEvent.data
      this.dataRundown = this.dataEvent.agenda_type
      this.payload_event = {
        eventName: dataEvent.data.event_title,
        eventStartDate: dataEvent.data.event_start,
        eventStartDateTime: this.getTime(dataEvent.data.event_start),
        eventEndDate: dataEvent.data.event_end,
        eventEndDateTime: this.getTime(dataEvent.data.event_end),
        eventLocation: dataEvent.data.event_location,
        eventDescription: dataEvent.data.event_description,
        eventStatus: dataEvent.data.event_status,
        eventPublishedStatus: dataEvent.data.event_publish,
        eventLinkMap: dataEvent.data.event_link_map,
        eventSource: dataEvent.data.event_source,
        eventContent: dataEvent.data.event_content,
        eventFile: '',
        eventTypeId: dataEvent.data.event_type_id,
      }
    },
    getTime(date) {
      const d = new Date(date);
      const  result = d.getHours().toString().padStart(2, '0') + ":" + d.getMinutes().toString().padStart(2, '0');
      return result;
    },
    async activateAgenda(id) {
      await fetch(config.public.baseURL + '/event/status_agenda/' + id, {
        method: 'GET'
      })
      this.loadEvent(this.paramId)
    },
    async activateDocument(id) {
      await fetch(config.public.baseURL + '/event/status_agenda_doc/' + id, {
        method: 'GET'
      })
      this.loadEvent(this.paramId)
    },
    openPopupAgenda(indexRundown, indexAgenda) {
      if (this.dataRundown[indexRundown].agenda[indexAgenda].agenda_document.length > 0) {
        this.isPopupAgenda = true
        this.selectedAgendaIndex.indexRundown = indexRundown
        this.selectedAgendaIndex.indexAgenda = indexAgenda
      }
    },

    openPopupAgendaType(indexRundown) {
      // if (this.dataRundown[indexRundown]) {
        this.isPopupAgendaType = true
        this.selectedAgendaTypeIndex = indexRundown
      // }
    },
    openPopupAgendaAdd(type) {
      this.isPopupAgendaAdd = true
      this.selectedAgendaTypeIndex = type
    },
    openPopupAgendaEdit(indexRundown, agendaId) {
      this.isPopupAgendaEdit = true
      this.selectedAgendaData = this.dataRundown[indexRundown].agenda.find(item => item.id === agendaId);
    },
    openPopupDeleteRundown(rundownId) {
      this.isPopupDeleteRundown = true
      this.selectedDeleteRundown = rundownId
    },
    togglePopupAgenda() {
      this.isPopupAgenda = !this.isPopupAgenda
    },
    togglePopupDeleteEvent() {
      this.isPopupDeleteEvent = !this.isPopupDeleteEvent
    },
    togglePopupDeleteAgenda(selectedDeleteAgenda = '') {
      if (selectedDeleteAgenda) {
        this.selectedDeleteAgenda = selectedDeleteAgenda
      } else {
        this.selectedDeleteAgenda = ''
      }
      this.isPopupDeleteAgenda = !this.isPopupDeleteAgenda
    },
    togglePopupAgendaType() {
      this.isPopupAgendaType = !this.isPopupAgendaType
      this.loadEvent(this.paramId)
    },
    togglePopupAgendaAdd() {
      this.isPopupAgendaAdd = !this.isPopupAgendaAdd
      this.loadEvent(this.paramId)
    },
    togglePopupAgendaEdit(reload = true) {
      this.isPopupAgendaEdit = !this.isPopupAgendaEdit
      if (reload) {
        this.loadEvent(this.paramId)
      }
    },
    togglePopupEditSuccess() {
      this.isPopupEditSuccess = !this.isPopupEditSuccess
    },
    togglePopupDeleteRundown() {
      this.isPopupDeleteRundown = !this.isPopupDeleteRundown
    },
    async deleteEvent() {
      await fetch(config.public.baseURL + '/event/' + this.paramId, {
        method: 'DELETE'
      })
      this.togglePopupDeleteEvent()
      this.$router.push('/admin/event')
    },
    async deleteAgenda() {
      await fetch(config.public.baseURL + '/event-agenda/' + this.selectedDeleteAgenda, {
        method: 'DELETE'
      })
      this.togglePopupDeleteAgenda()
      this.loadEvent(this.paramId)
    },
    async deleteRundown() {
      await fetch(config.public.baseURL + '/event/agenda-type/' + this.selectedDeleteRundown, {
        method: 'DELETE'
      })
      this.togglePopupDeleteRundown()
      this.loadEvent(this.paramId)
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
        this.payload_event.eventFile = event.target.files[0];
      } else {
        alert("File too big (> 10MB) or exclude extension")
        return
      }

    },
    async saveEvent() {
      this.isSubmit = true
      let formData = new FormData();

      formData.append("event_title", this.payload_event.eventName);
      formData.append("event_description", this.payload_event.eventDescription);
      formData.append("event_start", this.formatDatePayload(this.payload_event.eventStartDate, this.payload_event.eventStartDateTime));
      formData.append("event_end", this.formatDatePayload(this.payload_event.eventEndDate, this.payload_event.eventEndDateTime));
      formData.append("event_content", this.payload_event.eventContent);
      formData.append("event_source", this.payload_event.eventSource);
      formData.append("event_location", this.payload_event.eventLocation);
      formData.append("event_link_map", this.payload_event.eventLinkMap);
      formData.append("event_status", this.payload_event.eventStatus);
      formData.append("event_img_path", this.payload_event.eventFile);
      formData.append("event_type_id", this.payload_event.eventTypeId);

      const result = await fetch(config.public.baseURL + '/event/'+this.paramId, {
        method: 'POST',
        body: formData
      }).then(res => res.json())

      this.loadEvent(this.paramId)
      // this.isPopupEditSuccess = true
      this.$router.push('/admin/event')
    },
    formatDatePayload(date: string, time) {
      let date1 = new Date(date);
      let year = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(date1);
      let month = new Intl.DateTimeFormat('en', { month: '2-digit' }).format(date1);
      let day = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(date1);
      let times = time.split(":");

      return `${year}-${month}-${day} ${times[0]}:${times[1]}:00`
    },
  }
}
</script>