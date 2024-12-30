<div class="bg-white relative">
  <div class="border-b">
    <div class="container mx-auto py-4 flex justify-between max-w-7xl px-6">
      <div class="flex-1 flex gap-4 items-center">
        <img
          src="<?php echo base_url('assets/images/binus-logo.png'); ?>"
          class="flex-none"
          alt="Logo"
          width="60"
        />
        <div class="flex-none font-semibold text-xl text-gray-800">Sistem Prediksi Kinerja Akademik Mahasiswa BINUS
        </div>
      </div>
      <div class="flex-1 flex flex-row-reverse gap-3 items-center">
        <a href="<?php echo base_url('auth/logout'); ?>">
          <div class="ml-6 bg-red-400 py-2 px-5 text-white rounded-[20px] text-sm">Logout</div>
        </a>
        <a href="<?php echo base_url('profile'); ?>" class="flex gap-3">
          <div class="">
            <img src="https://spike-vue-horizontal.netlify.app/assets/user6-iQEKvgW-.jpg" class="rounded-full w-10 h-10">
          </div>
          <div>
            <div class="font-bold"><?= $this->session->userdata('user_name') ?></div>
            <div class="text-xs text-amber-700"><?= $this->session->userdata('user_role') ?></div>
          </div>
          
        </a>
      </div>
    </div>
  </div>
  <div class="container mx-auto py-5 flex gap-16 text-sm max-w-7xl px-6">
    <div class="flex-none flex items-center gap-3">
      <a href="<?php echo base_url('/dashboard'); ?>" class="flex items-center gap-3">
        <i class="material-icons text-blue-300 w-6">space_dashboard</i>
        Dashboard
      </a>
    </div>
    <div class="flex-none">
      <a href="<?php echo base_url('/student'); ?>" class="flex items-center gap-3">
        <i class="material-icons text-blue-300">group</i>
        Data Mahasiswa
      </a>
    </div>
    <div class="flex-none flex items-center gap-3">
      <a href="<?php echo base_url('/analysis'); ?>" class="flex items-center gap-3">
        <i class="material-icons text-blue-300 w-6">query_stats</i>
        Analisa
      </a>
    </div>
    <div class="flex-none flex items-center gap-3">
      <a href="<?php echo base_url('/campus'); ?>" class="flex items-center gap-3">
        <i class="material-icons text-blue-300">location_city</i>
        Kampus
      </a>
    </div>
    <?php if($this->session->userdata('user_role') == 'admin') { ?>
      <div class="flex-none flex items-center gap-3">
        <a href="<?php echo base_url('/user'); ?>" class="flex items-center gap-3">
          <i class="material-icons text-blue-300">admin_panel_settings</i>
          Pengguna
        </a>
      </div>
    <?php } ?>
  </div>
</div>

    