<template>
  <div>
    <InternalHeader />
    <div class="pt-4 pb-8 border-b-2 border-dashed text-center">
      <div class="w-32 h-32 rounded-full mx-auto">
        <img
          src="~/assets/images/profile.svg"
          class="mx-auto"
          alt="Profile"
        />
      </div>
      <div class="mt-4 text-xl font-black">{{ dataUser?.name  }}</div>
      <div class="mt-1">Frontend Developer</div>
    </div> 
    <div class="p-8 text-sm border-b-2 border-dashed">
      <div class="mb-8">
        <div class="font-black font-montserrat">Status</div>
        <div class="font-medium">Full Time Employee</div>
      </div>
      <div class="mb-8">
        <div class="font-black font-montserrat">Division</div>
        <div class="font-medium">Information Technology</div>
      </div>
      <div class="mb-8">
        <div class="font-black font-montserrat">Email</div>
        <div class="font-medium">{{ dataUser?.email  }}</div>
      </div>
      <div>
        <div class="font-black font-montserrat">Phone Number</div>
        <div class="font-medium">085857777414</div>
      </div>
    </div>
    <div class="p-8">
      <div class="font-black font-montserrat">Position History</div>
      <div class="mt-4 bg-primary-4 rounded-lg py-2 px-4">
        <div class="font-black font-montserrat">Full Time Current Position</div>
        <div class="font-medium">Current Division</div>
        <div class="mt-2">10/10/2023</div>
      </div>
      <div class="h-6 border-l-2 border-dashed w-1 mx-auto"></div>
      <div class="bg-primary-4 rounded-lg py-2 px-4">
        <div class="font-black font-montserrat">Join Date</div>
        <div class="mt-2">10/10/2022</div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">

export default {
  name: "InternalDashboard",
  data() {
    return {
      isMenuOpen: false,
      dataUser: null,
    }
  },
  mounted() {
    this.loadUser()
  },
  methods: {
    triggerMenu() {
      this.isMenuOpen = !this.isMenuOpen
    },
    loadUser() {
      const user = useCookie('user-internal')
      this.dataUser = user.value
    },
  },
}
</script>
