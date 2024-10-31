<div class="container mx-auto mt-8">
    <div class="bg-white rounded-[20px] shadow bg-white relative w-full">
        <div class="p-8">
            <h2 class="text-xl font-semibold mb-4">Kuesioner Mahasiswa Binus</h2>
            <div class="text-base text-gray-400 text-semibold leading-loose	mb-3 text-sm">Kuesioner ini digunakan untuk mengidentifikasi pola dan hubungan antara lokasi kampus dan kinerja akademik mahasiswa di Universitas Bina Nusantara (BINUS). Dengan hasil yang diperoleh, diharapkan pihak manajemen BINUS dapat merumuskan strategi yang lebih efektif dalam mendukung prestasi akademik mahasiswa di seluruh lokasi kampus, serta meningkatkan kualitas pendidikan secara keseluruhan.
            </div>
            <form action="<?= base_url('kuesioner/save/'); ?>" method="post">
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="student_name">Nama</label>
                    <input class="border rounded-[20px] py-2 px-3 w-full" type="text" id="student_name" name="student_name" value="" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="student_gpa">IPK</label>
                    <input class="border rounded-[20px] py-2 px-3 w-full" type="number" step="0.01" id="student_gpa" name="student_gpa" value="" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="student_transportation_access_score">Skor Akses Transportasi</label>
                    <div class="flex w-full">
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <div class="mr-4 flex-1">
                                <input 
                                    type="radio" 
                                    id="student_transportation_access_score_<?= $i; ?>" 
                                    name="student_transportation_access_score" 
                                    value="<?= $i; ?>" 
                                    required>
                                <label for="student_transportation_access_score_<?= $i; ?>" class="ml-2"><?= $i; ?></label>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="student_distance_to_campus_km">Jarak ke Kampus (km)</label>
                    <input class="border rounded-[20px] py-2 px-3 w-full" type="number" id="student_distance_to_campus_km" name="student_distance_to_campus_km" value="" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="student_address">Alamat</label>
                    <input class="border rounded-[20px] py-2 px-3 w-full" type="text" id="student_address" name="student_address" value="" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="student_enrollment_year">Tahun Angkatan</label>
                    <input class="border rounded-[20px] py-2 px-3 w-full" type="number" id="student_enrollment_year" name="student_enrollment_year" value="" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="area_id">Area Tempat Tinggal</label>
                    <select id="area_id" name="area_id" class="border rounded-[20px] py-2 px-3 w-full" required placeholder="Pilih Area">
                        <option value="1">Kota Besar</option>
                        <option value="2">Pinggiran Kota</option>
                        <option value="3">Desa</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="campus_id">Kampus</label>
                    <select class="border rounded-[20px] py-2 px-3 w-full" id="campus_id" name="campus_id" required>
                        <?php foreach ($campuses as $campus): ?>
                            <option value="<?= $campus->campus_id; ?>">
                                <?= $campus->campus_name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-[20px]">Simpan</button>
            </form>
        </div>
    </div>
</div>
