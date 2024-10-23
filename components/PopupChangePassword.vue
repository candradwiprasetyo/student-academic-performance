<template>
  <div>
    <div class="fixed inset-0 z-30 bg-black opacity-75"></div>
    <div class="fixed inset-0 z-30 flex items-center">
      <div class="mx-auto bg-white w-full md:w-[600px] md:rounded-lg h-screen md:h-auto md:px-2 md:pb-4">
        <div class="max-h-screen md:max-h-[90vh] relative">
          <div class="h-16 inline md:hidden w-full fixed bg-white z-50 border-b-2 border-gray-300">
            <img
              src="~/assets/images/close.svg"
              class="float-right cursor-pointer top-4 right-4 absolute"
              alt="close"
              @click="closePopup()"
            />
          </div>
          <div class="h-16 block md:hidden w-full"></div>
          <div class="absolute top-0 right-2 hidden md:inline z-30">
            <img
              src="~/assets/images/close.svg"
              class="float-right cursor-pointer"
              alt="close"
              @click="closePopup()"
            />
          </div>
          <div class="px-4 pb-4 mx-auto text-left md:w-600 relative font-medium">
            <div v-if="isSuccess">
              <div class="mt-4 pt-6 text-center">
                <img
                  src="~/assets/images/success.png"
                  class="mx-auto cursor-pointer w-20 h-20"
                  alt="success"
                />
                <div class="text-lg mt-4 text-center font-bold text-green-2 mb-6">Changed password successfully</div>
                <div class="text-white inline-block bg-green-2 py-2 px-4 rounded-lg font-bold mt-2 cursor-pointer" @click="closePopup()">Close</div>
              </div>
            </div>
            <div v-else>
              <div class="mt-4 text-xl font-extrabold capitalize font-montserrat text-green-2">
                Change Password
              </div>
              <div v-if="isNotMacth" class="bg-red-500 text-white p-2 mt-4 text-xs text-center rounded">Password does not match</div>
              <div v-if="isMinChar" class="bg-red-500 text-white p-2 mt-4 text-xs text-center rounded">Password min 8 characters</div>
              <div class="mt-5 text-primary-1">
                <div class="text-sm mb-1">New Password</div>
                <input
                  v-model="user.newPassword"
                  type="password"
                  placeholder="Enter your new password here"
                  name="new_password"
                  class="w-full text-xs rounded-lg py-2 px-4 border-primary-3"
                  required
                />
                <!-- <div class="text-2xs text-red-2 mt-1" v-if="validation.emptyNewPassword">This field is required to change password</div> -->
              </div>
              <div class="mt-5 text-primary-1">
                <div class="text-sm mb-1">Confirm New Password</div>
                <input
                  v-model="user.confirmNewPassword"
                  type="password"
                  placeholder="Enter confirm new password here"
                  name="confirm_new_password"
                  class="w-full text-xs rounded-lg py-2 px-4 border-primary-3"
                  required
                />
                <!-- <div class="text-2xs text-red-2 mt-1" v-if="validation.emptyConfirmNewPassword">This field is required to change password</div> -->
              </div>
              <div class="mt-5">
                <button 
                  @click.prevent="changePassword" 
                  class=" text-center w-full py-3 text-white font-bold rounded-lg"
                  :class="isButtonEnabled ? 'bg-green-2' : 'bg-gray-300'"
                >
                  Change Password
                </button>
              </div>
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
  name: "PopupChangePassword",
  props: {
    participantId: {
      type: Number,
      required: false,
    },
    participantName: {
      type: String,
      required: false,
    },
    participantEmail: {
      type: String,
      required: false,
    },
    memberId: {
      type: Number,
      required: false,
    },
  },
  data() {
    return {
      user: {
        newPassword: '',
        confirmNewPassword: '',
      },
      validation: {
        emptyNewPassword: false,
        emptyConfirmNewPassword: false,
      },
      isButtonEnabled: false,
      isFilled: false,
      isNotMacth: false,
      isSuccess: false,
      isMinChar: false,
    }
  },
  methods: {
    closePopup() {
      this.$emit('close-popup');
    },
    formChanged() {
      // this.validation.emptyNewPassword = (this.user.newPassword!='' && this.isFilled==true) ? false : true
      // this.validation.emptyConfirmNewPassword = (this.user.confirmNewPassword!='' && this.isFilled==true) ? false : true

      if (
        this.user.newPassword &&
        this.user.confirmNewPassword
      ) {
        this.isButtonEnabled = true
      } else {
        this.isButtonEnabled = false
      }
    },
    async changePassword() {
      this.isFilled = true
      if (this.user.newPassword != this.user.confirmNewPassword) {
        this.isNotMacth = true
      } else if (this.user.newPassword.length < 8) {
        this.isMinChar = true
      } else {
        const { data } = await useFetch(config.public.baseURL + '/participant/' + this.participantId, {
          method: 'post',
          headers: { 'Content-Type': 'application/json' },
          body: {
            participant_name: this.participantName,
            participant_email: this.participantEmail,
            member_id: this.memberId,
            participant_password: this.user.newPassword,
          },
        })
        if (data.value) {
          // this.$emit('close-popup');
          this.isSuccess = true
        } 
      }
    },
  },
  watch: {
    'user.newPassword' : function(val) { this.formChanged() },
    'user.confirmNewPassword' : function(val) { this.formChanged() },
  }
};
</script>