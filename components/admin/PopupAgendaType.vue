<template>
  <div>
    <div class="fixed inset-0 z-30 bg-black opacity-75"></div>
    <div class="fixed inset-0 z-30 flex items-center">
      <div class="w-1/2 mx-auto bg-white ">
        <div class="relative">
          <div class="fixed z-50 inline w-full h-16 bg-white border-b-2 border-gray-300 md:hidden">
            <img src="~/assets/images/close.svg" class="absolute float-right cursor-pointer right-4" alt="close"
              @click="closePopup()" />
          </div>
          <div class="block w-full h-16 md:hidden"></div>
          <div class="relative mx-auto font-medium text-left md:px-4">
            <div class="absolute z-50 hidden right-2 md:inline">
              <img src="~/assets/images/close.svg" class="float-right cursor-pointer" alt="close"
                @click="closePopup()" />
            </div>
          </div>
          <div class="relative px-4 pb-4 mx-auto font-medium text-left">
            <div class="pr-10 mt-4 text-xl font-extrabold capitalize font-montserrat text-green-2">
              Update Session
            </div>
            <div class="flex justify-between gap-4 mt-4">
              <div class="w-full mt-4">
                <div class="text-sm">Session</div>
                <input v-model="agenda_type_name" type="text" placeholder="Enter your Agenda Type here"
                  class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" />
              </div>
              <div class="w-full mt-4">
                <div class="text-sm">Keyword</div>
                <input v-model="agenda_type_keyword" type="text" placeholder="Enter your Agenda Type here"
                  class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" />
              </div>
            </div>
            <div class="flex justify-between mt-4">
              <button class="items-center gap-2 px-4 py-2 text-sm font-bold text-white bg-red-400 rounded-lg"
                @click="closePopup()">
                Cancel
              </button>
              <button class="items-center gap-2 px-4 py-2 text-sm font-bold text-white bg-blue-400 rounded-lg"
                @click="saveAgenda()">
                {{selectedAgendaTypeIndex == 99 ? "Add" : "Update"}} Session
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
const config = useRuntimeConfig()
export default {
  name: "PopupAgendaType",
  props: {
    dataRundown: {
      type: Array,
      required: false,
    },
    selectedAgendaTypeIndex: {
      type: String,
      required: false
    },
    eventId: {
      type: Number,
      required: false,
    }
  },
  data() {
  console.log("data",this.eventId)
    return {
      agenda_type_name: this.selectedAgendaTypeIndex == 99 ? "" : this.dataRundown[this.selectedAgendaTypeIndex].agenda_type_name,
      agenda_type_keyword: this.selectedAgendaTypeIndex == 99 ? "" : this.dataRundown[this.selectedAgendaTypeIndex].agenda_type_keyword
    }
  },

  methods: {
    closePopup() {
      this.$emit('close-popup');
    },
    async saveAgenda() {
      let url = ""
      if (this.selectedAgendaTypeIndex == 99) {
        url =  config.public.baseURL + '/event-agenda-type'
      }else{
        const agenda_type_id = this.dataRundown[this.selectedAgendaTypeIndex].id
        url = config.public.baseURL + '/event/agenda-type/'+ agenda_type_id
      }
      const result = await fetch(url, {
        method: 'POST',
        headers:{
          "Content-Type":"application/json"
        },
        body: JSON.stringify({
          agenda_type_name: this.agenda_type_name,
          agenda_type_keyword: this.agenda_type_keyword,
          event_id: this.eventId
        })
      }).then(res => res.json())

      this.closePopup()
    },
  }
};
</script>