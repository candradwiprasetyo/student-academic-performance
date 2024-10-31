<div class="container mx-auto mt-8">
  <div class="grid grid-cols-12 gap-10">
    <div class="lg:col-span-8 col-span-12">
      <div class="bg-white rounded-[30px] relative w-full relative">
        <div class="flex items-center justify-between">
          <div class="py-6 px-8">
            <div class="text-xl mb-1 opacity-50">Selamat datang di</div>
            <div class="text-2xl  font-semibold mb-6">Sistem Prediksi Kinerja Akademik Mahasiswa BINUS</div>
            <div class="text-base text-gray-400 text-semibold w-3/5 leading-loose	">Sistem ini digunakan untuk mengidentifikasi pola dan hubungan antara lokasi kampus dan kinerja akademik mahasiswa di Universitas Bina Nusantara (BINUS). Dengan hasil yang diperoleh, diharapkan pihak manajemen BINUS dapat merumuskan strategi yang lebih efektif dalam mendukung prestasi akademik mahasiswa di seluruh lokasi kampus, serta meningkatkan kualitas pendidikan secara keseluruhan.
            </div>
          </div>
        </div>
        <div class="absolute bottom-6 right-6">
          <img
            src="<?php echo base_url('assets/images/computer.png'); ?>"
            class="flex-none"
            width="260"
          />
        </div>
      </div>
    </div>
    <div class="lg:col-span-4 col-span-12">
      <div class="grid grid-cols-12">
        <div class="col-span-12 mb-8">
          <div class="rounded-[30px] bg-red-100 relative w-full relative">
            <div class="py-5 px-8">
              <div class="flex items-center gap-3">
                <span class="w-14 h-10 rounded-full flex items-center justify-center bg-red-400 text-white">
                  <i class="material-icons text-white">group</i>
                </span>
                <span class="text-base font-bold text-gray-600">Total Mahasiswa</span>
              </div>
              <div class="flex mt-16">
                <div class="text-3xl font-bold opacity-60"><?= $total_students ?></div>
              </div>
            </div>
            <div class="absolute bottom-0 right-6">
              <img
                src="<?php echo base_url('assets/images/mahasiswa.png'); ?>"
                class="flex-none"
                width="100"
              />
            </div>
          </div>
        </div>
        <div class="col-span-12">
          <div class="rounded-[30px] bg-blue-100 relative w-full relative">
            <div class="py-5 px-8">
              <div class="flex items-center gap-3">
                <span class="w-14 h-10 rounded-full flex items-center justify-center bg-blue-400 text-white">
                  <i class="material-icons text-white">location_city</i>
                </span>
                <span class="text-base font-bold text-gray-600">Total Kampus</span>
              </div>
              <div class="flex mt-16">
                <div class="text-3xl font-bold opacity-60"><?= $total_campus ?></div>
              </div>
            </div>
            <div class="absolute bottom-0 right-6">
              <img
                src="<?php echo base_url('assets/images/kampus.png'); ?>"
                class="flex-none"
                width="140"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>