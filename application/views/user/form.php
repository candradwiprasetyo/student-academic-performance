<div class="container mx-auto mt-8">
  <div class="bg-white rounded-[20px] shadow relative w-full">
    <div class="p-6">
      <h2 class="text-xl font-semibold mb-4"><?= $user ? 'Edit Pengguna' : 'Tambah Pengguna' ?></h2>
      <form action="<?= base_url('user/save' . ($user ? '/' . $user->user_id : '')); ?>" method="post">
          <div class="mb-4">
              <label class="block text-sm font-medium">Nama</label>
              <input type="text" name="user_name" value="<?= $user ? $user->user_name : ''; ?>" class="border rounded w-full p-2 rounded-[20px]" required>
          </div>
          <div class="mb-4">
              <label class="block text-sm font-medium">Email</label>
              <input type="email" name="user_email" value="<?= $user ? $user->user_email : ''; ?>" class="border rounded w-full p-2 rounded-[20px]" required>
          </div>
          <?php
          if (!$user) {
          ?>
            <div class="mb-4">
                <label class="block text-sm font-medium">Password</label>
                <input type="password" name="user_password" class="border rounded w-full p-2 rounded-[20px]" <?= $user ? '' : 'required'; ?>>
                <small class="text-gray-500">Kosongkan jika tidak ingin mengubah password.</small>
            </div>
          <?php } ?>
          <button type="submit" class="bg-blue-400 text-white py-2 px-4 rounded-l-[20px]">Simpan</button>
          <a href="<?= base_url('user'); ?>">
            <div class="bg-red-400 py-3 px-4 text-white rounded-r-[20px] text-sm h-10 inline">Batal</div>
          </a>
      </form>
    </div>
  </div>
</div>
