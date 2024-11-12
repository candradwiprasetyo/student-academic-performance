<div class="container mx-auto mt-8 max-w-7xl px-6">
    <div class="bg-white rounded-[20px] shadow bg-white relative w-full">
        <div class="p-8">
            <h2 class="text-xl font-semibold mb-4"><?= $student ? 'Edit Data Mahasiswa' : 'Tambah Data Mahasiswa'; ?></h2>
            <form action="<?= base_url('student/save/' . ($student ? $student->student_id : '')); ?>" method="post">
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="student_name">Nama</label>
                    <input class="border rounded-[20px] py-2 px-3 w-full" type="text" id="student_name" name="student_name" value="<?= $student ? $student->student_name : ''; ?>" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="student_gpa">IPK</label>
                    <input class="border rounded-[20px] py-2 px-3 w-full" type="number" step="0.01" id="student_gpa" name="student_gpa" value="<?= $student ? $student->student_gpa : ''; ?>" required>
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
                                    <?= ($student && $student->student_transportation_access_score == $i) ? 'checked' : ''; ?> 
                                    required>
                                <label for="student_transportation_access_score_<?= $i; ?>" class="ml-2"><?= $i; ?></label>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="student_distance_to_campus_km">Jarak ke Kampus (km)</label>
                    <input class="border rounded-[20px] py-2 px-3 w-full" type="number" id="student_distance_to_campus_km" name="student_distance_to_campus_km" value="<?= $student ? $student->student_distance_to_campus_km : ''; ?>" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="student_address">Alamat</label>
                    <input class="border rounded-[20px] py-2 px-3 w-full" type="text" id="student_address" name="student_address" value="<?= $student ? $student->student_address : ''; ?>" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="student_enrollment_year">Tahun Angkatan</label>
                    <input class="border rounded-[20px] py-2 px-3 w-full" type="number" id="student_enrollment_year" name="student_enrollment_year" value="<?= $student ? $student->student_enrollment_year : ''; ?>" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="area_id">Area</label>
                    <select id="area_id" name="area_id" class="border rounded-[20px] py-2 px-3 w-full" required placeholder="Pilih Area">
                        <option value="1" <?= ($student && $student->area_id == 1) ? 'selected' : ''; ?>>Kota Besar</option>
                        <option value="2" <?= ($student && $student->area_id == 2) ? 'selected' : ''; ?>>Pinggiran Kota</option>
                        <option value="3" <?= ($student && $student->area_id == 3) ? 'selected' : ''; ?>>Desa</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="campus_id">Kampus</label>
                    <select class="border rounded-[20px] py-2 px-3 w-full" id="campus_id" name="campus_id" required>
                        <?php foreach ($campuses as $campus): ?>
                            <option value="<?= $campus->campus_id; ?>" <?= ($student && $student->campus_id == $campus->campus_id) ? 'selected' : ''; ?>>
                                <?= $campus->campus_name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-l-[20px]">Simpan</button>
                <a href="<?= base_url('student'); ?>">
                    <div class="bg-red-400 py-3 px-4 text-white rounded-r-[20px] text-sm h-10 inline">Batal</div>
                </a>
            </form>
        </div>
    </div>
</div>
