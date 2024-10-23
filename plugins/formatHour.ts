export default defineNuxtPlugin(() => {
  return {
    provide: {
      formatHour: (value: string) =>  {
        if (value) {
          value = value?.toString()
          const newDate = value?.split(" ")
          const newHour = newDate[1]
          return newHour.substring(0,5)
        }
      },
    }
  }
})