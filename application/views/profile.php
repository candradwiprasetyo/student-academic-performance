<div class="container mx-auto mt-8">
    <div class="bg-white rounded-[20px] shadow relative w-full p-6">
        <h1 class="text-xl font-semibold mb-4">Update Profil</h1>
        <?php if ($this->session->flashdata('success')): ?>
            <div class="bg-green-500 text-white p-4 rounded-[20px]  my-4" id="alert">
                <?= $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="bg-red-500 text-white p-4 rounded-[20px]  my-4" id="alert">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
        <form action="<?= base_url('profile/update'); ?>" method="post">
            <div class="mb-4">
                <label for="user_name" class="block text-sm font-bold mb-2">Nama:</label>
                <input class="border rounded-[20px] py-2 px-3 w-full" type="text" id="user_name" name="user_name" value="<?= $user->user_name; ?>" required>
            </div>
            <div class="mb-4">
                <label for="user_email" class="block text-sm font-bold mb-2">Email</label>
                <input class="border rounded-[20px] py-2 px-3 w-full" type="email" id="user_email" name="user_email" value="<?= $user->user_email; ?>" required>
            </div>
            <div class="mb-4">
                <label for="user_password_old" class="block text-sm font-bold mb-2">Password Lama</label>
                <input class="border rounded-[20px] py-2 px-3 w-full" type="password" id="user_password_old" name="user_password_old" required>
            </div>
            <div class="mb-4">
                <label for="user_password" class="block text-sm font-bold mb-2">Password Baru (kosongkan jika tidak ingin mengubah)</label>
                <input class="border rounded-[20px] py-2 px-3 w-full" type="password" id="user_password" name="user_password">
            </div>
            <button type="submit" class="bg-blue-400 py-2 px-5 text-white rounded-[20px] text-sm font-bold">Simpan</button>
        </form>
    </div>
</div>
