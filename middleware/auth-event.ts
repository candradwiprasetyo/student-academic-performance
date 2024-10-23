import { useAuthEventStore } from '~/store/authEvent';

export default defineNuxtRouteMiddleware((to) => {
  const { authenticated } = storeToRefs(useAuthEventStore()); 
  const userEvent = useCookie('registration'); 

  if (userEvent.value) {
    authenticated.value = true; 
  }

  if (userEvent.value && to?.name === 'event') {
    return navigateTo('/event-logged');
  }

  if (!userEvent.value && to?.name !== 'event') {
    abortNavigation();
    return navigateTo('/event');
  }
});