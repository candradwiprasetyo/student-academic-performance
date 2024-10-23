<template>
  <div>
    <div class="fixed inset-0 z-50 flex items-center">
        <div class="w-full h-screen relative pt-14 overflow-hidden bg-white">
          <div class="h-16 inline w-full bg-white border-b-2 border-green-300">
            <div class="absolute top-2 left-2">
              <a :href="`${documentFile}`" download>
                <div class="bg-green-2 text-white rounded p-2 inline-block">Download PDF</div>
              </a>
              <!-- <a href="https://circabc.europa.eu/ui/group/34861680-e799-4d7c-bbad-da83c45da458/library/e126f816-844b-41a9-89ef-cb2a33b6aa56/details">
                <div class="bg-blue-500 text-white rounded ml-2 p-2 inline-block">FAQ</div>
              </a> -->
            </div>
            <!-- <img
              src="~/assets/images/close.svg"
              class="float-right cursor-pointer top-4 right-4 absolute"
              alt="close"
              @click="closePopup()"
            /> -->
            <div class="bg-red-500 text-white rounded p-2 float-right cursor-pointer top-2 right-2 absolute" @click="closePopup()">Back</div>
          </div>
          <div class="h-screen max-h-screen overflow-auto">
            <!-- <iframe title="PDF" :src="`https://cpopcdigiapp.org/documents/${documentFile}.pdf?v=8`" width="100%" height="100%" ></iframe> -->
            <!-- <iframe :src="`https://docs.google.com/viewer?url=https://cpopcdigiapp.org/documents/${documentFile}.pdf?v=8&embedded=true`" style="width:100%; height: calc(100vh - 64px);" frameborder="0"></iframe> -->
            <ClientOnly>
              <VuePdfEmbed :source="`${documentFile}`" />
            </ClientOnly>
           
          </div>
        </div>
     
    </div>
  </div>
</template>

<script>
export default {
  name: "PopupAgendaDetail",
  props: {
    documentId: {
      type: Number,
      required: false,
    },
    documentFile: {
      type: String,
      required: false
    }
  },
  methods: {
    closePopup() {
      this.$emit('close-popup');
    }
  }
};
</script>