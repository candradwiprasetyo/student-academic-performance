<template>
  <div>
    <div class="fixed inset-0 z-30 bg-black opacity-75"></div>
    <div class="fixed inset-0 z-30 flex items-center">
      <div class="w-3/4 mx-auto bg-white ">
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
              Tambah Agenda
            </div>
            <div class="flex flex-col gap-2 mt-4">
              <div class="flex justify-between gap-4">
                <div class="w-full mt-4">
                  <div class="text-sm">Order</div>
                  <input v-model="agenda_order" type="text" placeholder="Enter your Agenda Order here"
                    class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" />
                </div>
                <div class="w-full mt-4">
                  <div class="text-sm">Start Time</div>
                  <input v-model="agenda_start_time" type="text" placeholder="Enter your Agenda Start Time here"
                    class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" />
                </div>
                <div class="w-full mt-4">
                  <div class="text-sm">End Time</div>
                  <input v-model="agenda_end_time" type="text" placeholder="Enter your Agenda End Time here"
                    class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" />
                </div>
              </div>

              <div class="w-full mt-4">
                <div class="text-sm">Name</div>
                <input v-model="agenda_name" type="text" placeholder="Enter your Agenda Name here"
                  class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" />
              </div>
              <div class="w-full mt-4">
                <div class="text-sm">Description</div>
                <input v-model="agenda_description" type="text" placeholder="Enter your Agenda Description here"
                  class="w-full px-4 py-2 text-xs rounded-lg border-primary-3" />
              </div>
              <div class="mt-4">
                <div class="text-sm">Agenda Document</div>
                <input type="file" multiple @change="onUploadFiles" />
                <div class="text-2xs">HD Image <span class="px-2">&#x2022;</span> Max Size : 10 Mb <span
                    class="px-2">&#x2022;</span>
                  Allowed File : PNG/JPG/JPEG/PDF</div>
              </div>
              
            </div>
            <div class="flex justify-between mt-4">
              <button class="items-center gap-2 px-4 py-2 text-sm font-bold text-white bg-red-400 rounded-lg"
                @click="closePopup()">
                Cancel
              </button>
              <button class="items-center gap-2 px-4 py-2 text-sm font-bold text-white bg-blue-400 rounded-lg"
                @click="saveAgenda()">
                Save Agenda
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
  name: "PopupAgendaAdd",
  props: {
    selectedAgendaTypeIndex: {
      type: String,
      required: false
    },
  },
  data() {
    return {
      agenda_order: '',
      agenda_name: '',
      agenda_description: '',
      agenda_start_time: '',
      agenda_end_time: '',
      agenda_doc: ''
    }
  },

  methods: {
    closePopup() {
      this.$emit('close-popup');
    },
    async saveAgenda() {
      let formData = new FormData();

      formData.append("agenda_order", this.agenda_order);
      formData.append("agenda_name", this.agenda_name);
      formData.append("agenda_description", this.agenda_description);
      formData.append("agenda_start_time", this.agenda_start_time);
      formData.append("agenda_end_time", this.agenda_end_time);
      formData.append("agenda_type_id", this.selectedAgendaTypeIndex);
      for (let i = 0; i < this.agenda_doc.length; i++) {
          const file = this.agenda_doc[i];
          formData.append("agenda_doc[" + i + "]", file);
        }

      const result = await fetch(config.public.baseURL + '/event-agenda', {
        method: 'POST',
        body: formData
      }).then(res => res.json())

      this.closePopup()
    },
    onUploadFiles(event) {
      const allowExtension = [
        "application/pdf",
        "image/jpeg",
        "image/jpg",
        "image/png",
      ];
      if (
        allowExtension.includes(event.target.files[0].type) &&
        event.target.files[0].size / (1024 * 1024) < 10
      ) {
        this.agenda_doc = event.target.files;
      } else {
        alert("File too big (> 10MB) or exclude extension")
        return
      }

    },
  }
};
</script>