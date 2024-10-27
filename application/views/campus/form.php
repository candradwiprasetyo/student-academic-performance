<div class="container mx-auto mt-8">
    <div class="bg-white rounded-[20px] shadow relative w-full">
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-4"><?= $campus ? 'Edit' : 'Tambah' ?> Data Kampus</h2>
            <form action="<?= base_url('campus/save/' . ($campus ? $campus->campus_id : '')); ?>" method="POST">
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="campus_name">Nama Kampus</label>
                    <input type="text" name="campus_name" id="campus_name" class="border rounded w-full py-2 px-3 rounded-[20px]" value="<?= $campus ? $campus->campus_name : ''; ?>" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="campus_address">Alamat Kampus</label>
                    <input type="text" name="campus_address" id="campus_address" class="border rounded w-full py-2 px-3 rounded-[20px]" value="<?= $campus ? $campus->campus_address : ''; ?>" required>
                </div>
                <div>
                    <button type="submit" class="bg-blue-400 py-2 px-4 text-white rounded-l-[20px] text-sm h-10"><?= $campus ? 'Simpan Perubahan' : 'Tambah Data' ?></button>
                    <a href="<?= base_url('campus'); ?>">
                      <div class="bg-red-400 py-3 px-4 text-white rounded-r-[20px] text-sm h-10 inline">Batal</div>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>