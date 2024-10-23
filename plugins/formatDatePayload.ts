export default defineNuxtPlugin(() => {
  return {
    provide: {
      // return tanggal nama bulan dan tahun
      formatDatePayload: (date: string) => {
        let date1 = new Date(date);
        let year = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(date1);
        let month = new Intl.DateTimeFormat('en', { month: '2-digit' }).format(date1);
        let day = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(date1);

        return `${year}-${month}-${day}`
      },
    }
  }
})