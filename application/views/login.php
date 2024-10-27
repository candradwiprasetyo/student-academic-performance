
<div> 
  <form action="<?php echo base_url('auth/do_login'); ?>" method="post">
    <div class="w-full h-screen md:flex">
      <div class="flex-1 bg-cover bg-center relative bg-primary content-center flex items-center w-full min-h-[200px]">
        <div class="absolute bg-blue-300 inset-0 opacity-50">
          <img
              src="<?php echo base_url('assets/images/binus-logo-white.png'); ?>"
              class="mx-auto mb-10 w-[50%] mt-[25%]"
              alt="Logo"
            />
        </div>
      </div>
      <div class="flex-1 content-center flex items-center px-8 md:px-0 bg-white">
        <div class="w-full md:w-[400px] mx-auto font-medium py-8 md:py-0">
          <div class="hidden md:inline">
            <img
              src="<?php echo base_url('assets/images/binus-logo.png'); ?>"
              class="mx-auto mb-10"
              alt="Logo"
              width="164"
              height="164"
            />
          </div>
          <div>
            <div class="text-lg font-extrabold font-montserrat text-center">Sistem Prediksi Kinerja Akademik <br>Mahasiswa BINUS</div>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="bg-red-500 text-white p-2 mt-4 text-xs text-center rounded">
                    <?php echo $this->session->flashdata('error'); ?>
                    <div class="bg-red-500 text-white p-2 mt-4 text-xs text-center rounded hidden">Login failed. Wrong email or password</div>
                </div>
            <?php endif; ?>
            <div class="mt-2 md:mt-5 text-primary-1">
              <div class="text-sm mb-2">Email</div>
              <input
                type="text"
                placeholder="Enter email here"
                name="email"
                class="w-full text-xs rounded-[20px] py-2 px-4 border"
                required
              />
            </div>
            <div class="mt-5 text-primary-1">
              <div class="text-sm mb-2">Password</div>
              <input
                type="password"
                placeholder="Enter your password here"
                name="password"
                class="w-full text-xs rounded-[20px] py-2 px-4 border"
                required
              />
            </div>
            <div class="mt-5">
              <button 
                class=" text-center w-full py-3 text-white font-bold rounded-[30px] bg-primary"
              >
                Login
              </button>
            </div>
          </div>
          
          <div class="mt-2 md:mt-4 text-center text-2xs font-medium">Copyright © 2024. All rights reserved.</div>
        </div>
      </div>
    </div>
  </form>
</div>