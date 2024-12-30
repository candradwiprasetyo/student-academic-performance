<div class="container mx-auto mt-8 max-w-7xl px-6">
  <div class="bg-white rounded-[20px] shadow relative w-full">
    <div class="flex items-center justify-between">
      <div class="pt-6 px-8">
        <div class="text-xl font-semibold mb-1">Data Pengguna</div>
        <div class="text-sm text-gray-400 text-semibold">Total <?= $total_users; ?> data</div>
      </div>
      <div class="pr-6">
        <a href="<?= base_url('user/form'); ?>" class="bg-blue-400 py-2 px-5 text-white rounded-[20px] text-sm font-bold">Tambah Data</a>
      </div>
    </div>
    <div class="flex justify-between px-6">
        <div class="relative flex-1">
            <form id="searchForm" action="<?= base_url('user'); ?>" method="get">
                <input type="text" name="user_name" placeholder="Cari nama pengguna" 
                        class="border py-2 px-4 rounded-[20px] text-sm w-[30%] float-right" value="<?= $this->input->get('user_name'); ?>" >
                
            </form>
        </div>
    </div>
    <div class="pb-6">
      <?php if ($this->session->flashdata('success')): ?>
          <div class="bg-green-500 text-white p-4 rounded-[20px] mx-8 mt-4 flex items-center gap-4" id="alert">
            <i class="material-icons text-white w-6">check</i> <?= $this->session->flashdata('success'); ?>
          </div>
      <?php endif; ?>
      <table class="w-full text-sm text-left">
          <thead>
              <tr>
                  <th class="p-8 pb-4">Nomor</th>
                  <th class="pt-8 pb-4">Nama</th>
                  <th class="pt-8 pb-4">Email</th>
                  <th class="pt-8 pb-4">Role</th>
                  <th align="right" class="pt-8 pb-4 pr-8"></th>
              </tr>
          </thead>
          <tbody>
                <?php
                    $nomor = 1;  
                    foreach ($users as $row): 
                ?>
                  <tr class="border-t">
                      <td class="pl-8 py-3"><?= $nomor++ ?></td>
                      <td><?= $row->user_name; ?></td>
                      <td><?= $row->user_email; ?></td>
                      <td><?= $row->user_role; ?></td>
                      <td align="right" class="pr-6">
                        <a href="<?= base_url('user/form/' . $row->user_id); ?>" class="bg-green-400 py-2 px-5 text-white rounded-l-[20px] text-sm font-bold">Edit</a>
                        <a href="<?= base_url('user/delete/' . $row->user_id); ?>" class="bg-red-400 py-2 px-5 text-white rounded-r-[20px] text-sm font-bold" onclick="return confirm('Anda yakin ingin menghapus data ini?');">Hapus</a>
                      </td>
                  </tr>
              <?php endforeach; ?>
          </tbody>
      </table>
    </div>
  </div>
</div>
