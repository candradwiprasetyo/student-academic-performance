<template>
  <div>
    <div class="fixed inset-0 z-30 bg-black opacity-75"></div>
    <div class="fixed inset-0 z-30 flex items-center">
      <div class="mx-auto bg-white w-full md:w-full h-screen md:h-screen md:px-2">
        <div class="h-screen overflow-auto relative">
          <div class="h-16 inline md:hidden w-full fixed bg-white z-50 border-b-2 border-gray-300">
            <!-- <img
              src="~/assets/images/close.svg"
              class="float-right cursor-pointer top-4 right-4 absolute"
              alt="close"
              @click="closePopup()"
            /> -->
            <div class="bg-red-500 text-white rounded p-2 float-right cursor-pointer mt-3 mr-3" @click="closePopup()">Back</div>
          </div>
          <div class="h-16 block md:hidden w-full"></div>
          <div class="md:px-4 mx-auto text-left relative font-medium">
            <div class="absolute top-4 right-2 hidden md:inline z-50">
              <!-- <img
                src="~/assets/images/close.svg"
                class="float-right cursor-pointer"
                alt="close"
                @click="closePopup()"
              /> -->
              <div class="bg-red-500 text-white rounded p-2 float-right cursor-pointer" @click="closePopup()">Back</div>
            </div>
          </div>
          <div class="px-4 pb-4 mx-auto text-left relative font-medium">
            <div class="mt-4 text-xl font-extrabold capitalize font-montserrat text-green-2 pr-10">
              {{ dataRundown[selectedAgendaIndex.indexRundown].agenda[selectedAgendaIndex.indexAgenda].agenda_name }}
            </div>
            <div class="text-sm text-primary-1 pb-2 mt-4">
              {{ dataRundown[selectedAgendaIndex.indexRundown].agenda[selectedAgendaIndex.indexAgenda].agenda_description }}
            </div>
            <div class="md:flex h-[80vh] gap-4">
              <div class="md:w-1/4 border-primary-4 rounded-lg overflow-auto">
                <div class="border-b flex items-center px-3 bg-gray-50">
                  <img
                    src="~/assets/images/search.png"
                    class="w-4 h-4"
                    alt="search"
                  />
                  <input type="text" v-model="search" placeholder="Search bookmark.." class="p-4  w-full outline-none bg-gray-50" />
                </div>
                <table class="w-full">
                  <!-- <tr class="text-xs md:text-base text-left border-b-2 border-gray-100 font-black">
                    <th width="60%" class="p-4 px-4">Document Name</th>
                  </tr> -->
                  <tr class="text-sm md:text-base border-b-2 border-gray-100" v-for="document in filteredList" :key="document.id" :class="document.status==1 ? 'bg-yellow-50' : ''">
                    <td class="pl-3">
                      <span class="relative flex h-3 w-3" v-if="document.status==1">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                      </span>
                    </td>
                    <td class="py-3 md:py-4 px-4">
                      <span @click="viewDocument(document.id, document.url_doc)" class="cursor-pointer hidden md:block">{{ document.agenda_doc_name }}</span>
                      <span @click="openPopupAgendaDetail(document.id, document.url_doc)" class="cursor-pointer block md:hidden">{{ document.agenda_doc_name }}</span>
                    </td>
                  </tr>
                </table>
              </div>
              <div class="md:w-3/4 hidden md:block">
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
    typeMember: {
      type: Number,
      required: false,
    }
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
    }
  }
};
</script>