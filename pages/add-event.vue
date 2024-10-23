<template>
  <div class="p-4">
    <form @submit.prevent="saveEvent">
      <div class="text-lg font-extrabold text-green-2 font-montserrat">Update Event</div>
      <div class="mt-8">
        <div class="text-sm">Event Name</div>
        <input v-model="eventName" type="text" placeholder="Enter your event name here" name="eventName"
          class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required />
      </div>
      <div class="flex gap-4 mt-4">
        <div class="flex-1">
          <div class="text-sm">Event Start Date</div>
          <div class="flex gap-3">
            <div class="flex-1">
              <client-only>
                <v-date-picker v-model="eventStartDate">
                  <template v-slot="{ inputValue, inputEvents }">
                    <input id="input-publication-date" name="publication-date" type="text"
                      class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" :value="inputValue" v-on="inputEvents"
                      placeholder="dd/mm/yyyy" readonly />
                  </template>
                </v-date-picker>
              </client-only>
            </div>
            <div class="flex-1">
              <input v-model="eventStartDateTime" type="text" placeholder="00:00" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required />
            </div>
          </div>
        </div>
        <div class="flex-1">
          <div class="text-sm">Event End Date</div>
          <div class="flex gap-3">
            <div class="flex-1">
              <client-only>
                <v-date-picker v-model="eventEndDate">
                  <template v-slot="{ inputValue, inputEvents }">
                    <input id="input-publication-date" name="publication-date" type="text"
                      class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" :value="inputValue" v-on="inputEvents"
                      placeholder="dd/mm/yyyy" readonly />
                  </template>
                </v-date-picker>
              </client-only>
            </div>
            <div class="flex-1">
              <input v-model="eventEndDateTime" type="text" placeholder="00:00" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required />
            </div>
          </div>
        </div>
      </div>
      <div class="mt-4">
        <div class="text-sm">Location</div>
        <input v-model="eventLocation" type="text" placeholder="Enter your event location here"
          class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required />
      </div>
      <div class="mt-4">
        <div class="text-sm">Link Map</div>
        <input v-model="eventLinkMap" type="text" placeholder="Enter your event link map here"
          class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required />
      </div>
      <div class="mt-4">
        <div class="text-sm">Source</div>
        <input v-model="eventSource" type="text" placeholder="Enter your event source here"
          class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required />
      </div>
      <div class="mt-4">
        <div class="text-sm">Description</div>
        <textarea v-model="eventDescription" placeholder="Enter your event description here" name="eventDescription"
          class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required></textarea>
      </div>
      <div class="mt-4">
        <div class="text-sm">Content</div>
        <textarea v-model="eventContent" placeholder="Enter your event content here" name="eventContent"
          class="w-full px-4 py-2 text-xs rounded-lg border-primary-3"></textarea>
      </div>
      <div class="flex gap-4 mt-4">
        <div class="flex-1">
          <div class="text-sm">Event Status</div>
          <select v-model="eventStatus" placeholder="Enter your event status here" name="eventName"
            class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required>
            <option value="0" selected>Inactive</option>
            <option value="1">Active</option>
          </select>
        </div>
        <div class="flex-1">
          <div class="text-sm">Published Status</div>
          <select v-model="eventPublishedStatus" placeholder="Enter your event date here" name="eventPublishedStatus"
            class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required>
            <option value="0" selected>Unpublish</option>
            <option value="1">Publish</option>
          </select>
        </div>
      </div>
      <div class="mt-4">
        <div class="text-sm">Event Type</div>
        <select placeholder="Enter event type" v-model="eventTypeId"
          name="eventTypeId" class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" required>
          <option value="1" selected>Public</option>
          <option value="2">Official</option>
          <option value="3">Internal</option>
        </select>
      </div>
      <div class="mt-4">
        <div class="text-sm">Image / Banner</div>
        <input type="file" @change="onUploadFiles" />
        <div class="text-2xs">HD Image <span class="px-2">&#x2022;</span> Max Size : 10 Mb <span
            class="px-2">&#x2022;</span>
          Allowed File : PNG/JPG/JPEG</div>
      </div>

      <!-- type event -->
      <div class="py-4 ">
        <table class="w-full">
          <tr class="text-xs font-black text-left border-b-2 border-gray-100 md:text-sm">
            <th width="40%" class="p-2 px-2 md:px-4">Agenda Type</th>
            <th width="15%" class="p-2 px-2 md:px-4">Keyword</th>
            <th width="10%" class="p-2 px-2 md:px-4"></th>
          </tr>
          <tr class="border-b-2 border-gray-100 text-2xs md:text-xs" v-for="item, index in agendaType" :key="item.id">
            <td class="px-1 py-3 md:py-2 md:px-4">{{ item.agenda_type_name }}</td>
            <td class="px-1 py-3 md:py-2 md:px-4">{{ item.agenda_type_keyword }}</td>
            <td class="flex px-1 py-3 md:py-2 md:px-4">
              <div class="pl-0 text-sm font-bold text-center rounded-lg cursor-pointer"
                @click="updateAgendaType(item.agenda_type_name, item.agenda_type_keyword, index)">
                <img src="~/assets/images/edit.svg" class="inline-block mx-auto ml-2 cursor-pointer" alt="Edit" width="32"
                  height="32" />
              </div>
              <div class="pl-0 text-sm font-bold text-center rounded-lg cursor-pointer" @click="deleteAgendaType(index)">
                <img src="~/assets/images/delete.svg" class="inline-block mx-auto ml-2 cursor-pointer" alt="Delete"
                  width="32" height="32" />
              </div>
            </td>
          </tr>
        </table>
        <div class="flex gap-4 mt-4">
          <div class="flex-1">
            <input v-model="agenda.agenda_type_name" type="text" placeholder="Enter your Agenda Type here"
              class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" />
          </div>
          <div class="flex-1">
            <input v-model="agenda.agenda_type_keyword" type="text" placeholder="Enter your Keyword here"
              class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" />
          </div>
          <button class="flex items-center gap-2 px-4 py-2 text-sm font-bold text-white bg-blue-400 rounded-lg"
            @click="saveAgenda()">
            Save Agenda Type
          </button>
        </div>
      </div>

      <div class="flex justify-end gap-2">
        <button class="flex items-center gap-2 px-4 py-2 text-sm font-bold text-white bg-orange-400 rounded-lg"
          @click="goToPrev()">
          Cancel
        </button>
        <button class="flex items-center gap-2 px-4 py-2 text-sm font-bold text-white rounded-lg bg-green-2"
          :disabled="isSubmit"
          >
          {{ isSubmit ? 'Saving...' : 'Save' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script lang="ts" setup>
definePageMeta({
  layout: 'admin',
})
</script>

<script lang="ts">
const config = useRuntimeConfig()
const { $formatDatePayload } = useNuxtApp()

export default {
  name: "AddEvent",
  data() {
    return {
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
      agendaType: [],
      eventTypeId: '',
      agenda: {
        agenda_type_name: '',
        agenda_type_keyword: ''
      },
      agendaIndex: null,
      isSubmit: false,
    }
  },
  methods: {
    formatDatePayload(date: string, time) {
      let date1 = new Date(date);
      let year = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(date1);
      let month = new Intl.DateTimeFormat('en', { month: '2-digit' }).format(date1);
      let day = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(date1);
      let times = time.split(":");

      return `${year}-${month}-${day} ${times[0]}:${times[1]}:00`
    },

    async saveEvent() {
      this.isSubmit = true
      let formData = new FormData();

      formData.append("event_title", this.eventName);
      formData.append("event_description", this.eventDescription);
      formData.append("event_start", this.formatDatePayload(this.eventStartDate, this.eventStartDateTime));
      formData.append("event_end", this.formatDatePayload(this.eventEndDate, this.eventEndDateTime));
      formData.append("event_content", this.eventContent);
      formData.append("event_source", this.eventSource);
      formData.append("event_location", this.eventLocation);
      formData.append("event_link_map", this.eventLinkMap);
      formData.append("event_status", this.eventStatus);
      formData.append("event_img_path", this.eventFile);
      formData.append("event_type_id", this.eventTypeId);
      this.agendaType.forEach(element => {
        formData.append("agenda_type_name[]", element?.agenda_type_name);
        formData.append("agenda_type_keyword[]", element?.agenda_type_keyword);
      });

      const result = await fetch(config.public.baseURL + '/event', {
        method: 'POST',
        body: formData
      }).then(res => res.json())

      return navigateTo('/admin/event')

    },
    goToPrev() {
      this.$router.go(-1)
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
        this.eventFile = event.target.files[0];
      } else {
        alert("File too big (> 10MB) or exclude extension")
        return
      }

    },

    saveAgenda() {
      if (this.agendaIndex != null) {
        this.agendaType[this.agendaIndex] = {
          agenda_type_name: this.agenda.agenda_type_name,
          agenda_type_keyword: this.agenda.agenda_type_keyword
        }
      } else {
        this.agendaType.push(this.agenda)
      }
      this.agenda = {
        agenda_type_name: '',
        agenda_type_keyword: ''
      }
      this.agendaIndex = null
    },

    updateAgendaType(name, keyword, index) {
      this.agendaIndex = index
      this.agenda = {
        agenda_type_name: name,
        agenda_type_keyword: keyword
      }
    },

    deleteAgendaType(index) {
      this.agendaType.splice(index)
    }
  }
}
</script>