import { setupCalendar, Calendar, DatePicker } from 'v-calendar';
import 'v-calendar/style.css';

export default defineNuxtPlugin((nuxtApp) => {
  // Use plugin defaults (optional)
  nuxtApp.vueApp.use(setupCalendar, {})

  // Use the components
  nuxtApp.vueApp.component('VCalendar', Calendar)
  nuxtApp.vueApp.component('VDatePicker', DatePicker)
})