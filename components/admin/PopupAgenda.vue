<template>
  <div>
    <div class="fixed inset-0 z-30 bg-black opacity-75"></div>
    <div class="fixed inset-0 z-30 flex items-center">
      <div class="w-full h-screen mx-auto bg-white md:w-full md:h-screen md:px-2">
        <div class="relative h-screen overflow-auto">
          <div class="fixed z-50 inline w-full h-16 bg-white border-b-2 border-gray-300 md:hidden">
            <img
              src="~/assets/images/close.svg"
              class="absolute float-right cursor-pointer top-4 right-4"
              alt="close"
              @click="closePopup()"
            />
          </div>
          <div class="block w-full h-16 md:hidden"></div>
          <div class="relative mx-auto font-medium text-left md:px-4">
            <div class="absolute z-50 hidden top-4 right-2 md:inline">
              <img
                src="~/assets/images/close.svg"
                class="float-right cursor-pointer"
                alt="close"
                @click="closePopup()"
              />
            </div>
          </div>
          <div class="relative px-4 pb-4 mx-auto font-medium text-left">
            <div class="pr-10 mt-4 text-xl font-extrabold capitalize font-montserrat text-green-2">
              {{ dataRundown[selectedAgendaIndex.indexRundown].agenda[selectedAgendaIndex.indexAgenda].agenda_name }}
            </div>
            <div class="pb-2 mt-4 text-sm text-primary-1">
              {{ dataRundown[selectedAgendaIndex.indexRundown].agenda[selectedAgendaIndex.indexAgenda].agenda_description }}
            </div>
            <div class="md:flex h-[80vh] gap-4">
              <div class="overflow-auto rounded-lg md:w-1/2 border-primary-4">
                <div class="flex items-center px-3 border-b bg-gray-50">
                  <img
                    src="~/assets/images/search.png"
                    class="w-4 h-4"
                    alt="search"
                  />
                  <input type="text" v-model="search" placeholder="Search bookmark.." class="w-full p-4 outline-none bg-gray-50" />
                </div>
                <table class="w-full">
                  <tr class="text-sm border-b-2 border-gray-100 md:text-base" v-for="document in filteredList" :key="document.id" :class="document.status==1 ? 'bg-yellow-50' : ''">
                    <td class="pl-3">
                      <span class="relative flex w-3 h-3" v-if="document.status==1">
                        <span class="absolute inline-flex w-full h-full bg-green-400 rounded-full opacity-75 animate-ping"></span>
                        <span class="relative inline-flex w-2 h-2 bg-green-500 rounded-full"></span>
                      </span>
                    </td>
                    <td class="px-4 py-3 md:py-4">
                      <span @click="viewDocument(document.id, document.url_doc)" class="hidden cursor-pointer md:block">{{ document.agenda_doc_name }}</span>
                      <span @click="openPopupAgendaDetail(document.id, document.url_doc)" class="block cursor-pointer md:hidden">{{ document.agenda_doc_name }}</span>
                    </td>
                    <td class="text-right">
                      <div :class="document.status==1 ? 'bg-red-100' : 'bg-green-4'" class="px-3 py-2 mr-3 text-xs font-bold text-center rounded-lg cursor-pointer text-green-2" @click="activateDocument(document.id)">{{ (document.status==1) ? 'Deactivate' : 'Activate' }}</div>
                    </td>
                  </tr>
                </table>
              </div>
              <div class="hidden md:w-1/2 md:block">
                <iframe title="PDF" :src="`${(documentFile) ? documentFile : dataRundown[selectedAgendaIndex.indexRundown].agenda[selectedAgendaIndex.indexAgenda].agenda_document[0].url_doc}`" width="100%" height="100%" ></iframe>
                <!-- <iframe width="100%" height="100%" :src="`https://intranet.ddtc.co.id/assets/js/web/viewer.html?file=https://cpopcdigiapp.org/documents/${(documentId) ? documentId : dataRundown[selectedAgendaIndex.indexRundown].agenda[selectedAgendaIndex.indexAgenda].agenda_document[0].id}.pdf?v=3`"  allowfullscreen webkitallowfullscreen></iframe> -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <PopupAgendaDetail
        :documentId="documentId"
        :documentFile="documentFile"
        @close-popup="closePopupAgendaDetail"
        v-if="isPopupAgendaDetail"
      />
    </div>
  </div>
</template>

<script>
const config = useRuntimeConfig()
export default {
  name: "PopupAgenda",
  props: {
    dataRundown: {
      type: Array,
      required: false,
    },
    selectedAgendaIndex: {
      type: Object,
      required: false
    },
  },
  data() {
    return {
      documentId: '',
      documentFile: '',
      isPopupAgendaDetail: false,
      search: '',
    }
  },
  computed: {
    filteredList() {
      return this.dataRundown[this.selectedAgendaIndex.indexRundown].agenda[this.selectedAgendaIndex.indexAgenda].agenda_document.filter(post => {
        return post.agenda_doc_name.toLowerCase().includes(this.search.toLowerCase())
      })
    }
  },
  methods: {
    closePopup() {
      this.$emit('close-popup');
    },
    closePopupAgendaDetail() {
      this.isPopupAgendaDetail = false
      // document.documentElement.style.overflow = 'auto';
    },
    openPopupAgendaDetail(documentId, documentFile) {
      this.isPopupAgendaDetail = true
      // document.documentElement.style.overflow = 'hidden';
      this.documentId = documentId
      this.documentFile = documentFile
    },
    viewDocument(documentId, documentFile) {
      this.documentId = documentId
      this.documentFile = documentFile
    },
    activateDocument(id) {
      this.$emit('activate-document', id);
    },
    // async activateDocument(id) {
    //   await fetch(config.public.baseURL + '/event/status_agenda_doc/' + id, {
    //     method: 'GET'
    //   })
    //   this.loadEvent()
    // },
  }
};
</script>