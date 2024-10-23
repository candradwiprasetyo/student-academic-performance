<template>
  <div>
    <div class="rounded-lg p-8 bg-white shadow">
      <div class="flex justify-between">
        <div class="font-black text-lg">Participant Page</div>
        <!-- <NuxtLink to="add-event">
          <div class="bg-green-2 rounded-lg	py-2 px-4 text-white font-bold items-center flex gap-2 text-sm ">
            <img
              src="~/assets/images/event.svg"
              class="mx-auto w-6 h-6 inline-block flex-none"
              alt="event menu"
            />
            <span class="flex-grow">Add New Participant</span>
          </div>
        </NuxtLink> -->
      </div>
      <div class="border-primary-4 rounded-lg mt-4">
        <table class="w-full">
          <tr class="text-xs md:text-sm text-left border-b-2 border-gray-100 font-black">
            <th width="5%" class="p-2 px-2 md:px-4">No</th>
            <th width="30%" class="p-2 px-2 md:px-4">Name</th>
            <th width="15%" class="p-2 px-2 md:px-4">Email</th>
            <!-- <th width="15%" class="p-2 px-2 md:px-4">Password</th> -->
            <th width="15%" class="p-2 px-2 md:px-4">Country</th>
            <th width="15%" class="p-2 px-2 md:px-4"></th>
          </tr>
          <tr class="text-2xs md:text-xs border-b-2 border-gray-100" v-for="participant, indexParticipant in dataParticipant" :key="participant.id">
            <td class="text-center">{{  indexParticipant+1 }}</td>
            <td class="py-3 md:py-2 px-1 md:px-4">
              {{ participant.participant_name  }}
            </td>
            <td class="py-3 md:py-2 px-1 md:px-4">{{ participant.participant_email  }}</td>
            <!-- <td class="py-3 md:py-2 px-1 md:px-4">{{ participant.participant_password  }}</td> -->
            <td class="py-3 md:py-2 px-1 md:px-4">{{ participant.member.member_name  }}</td>
            <td class="py-3 md:py-2 px-1 md:px-4"></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
definePageMeta({
  layout: 'admin',
})

const config = useRuntimeConfig()

export default {
  name: "EventParticipant",
  data() {
    return {
      dataParticipant: [],
    }
  },
  mounted() {
    this.loadParticipant()
  },
  methods: {
    async loadParticipant () {
      const dataParticipant = await fetch(config.public.baseURL + '/participant?limit=9999').then(res => res.json())
      if ( dataParticipant?.data.data.length > 0) {
        this.dataParticipant = dataParticipant.data.data
      }
    },
  }
}
</script>