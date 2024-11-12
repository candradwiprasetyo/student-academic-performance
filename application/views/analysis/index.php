<div class="container mx-auto mt-8 max-w-7xl px-6">
  <div class="bg-white rounded-[20px] shadow bg-white relative w-full p-8">
    <h1 class="text-xl font-bold mb-4">Hasil Model Decision Tree</h1>

    <!-- Form upload JSON -->
    <form action="<?= base_url('analysis/upload_json'); ?>" method="post" enctype="multipart/form-data">
        <div class="mb-4">
            <label for="json_file" class="block font-semibold">Unggah File JSON</label>
            <input type="file" name="json_file" class="border p-2 rounded-[20px] text-sm w-full" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white py-2 px-5 rounded-[20px] text-sm font-bold">Unggah</button>
        <?php if ($this->session->flashdata('success')): ?>
            <div class="bg-green-500 text-white p-4 rounded-[20px] mt-4"><?= $this->session->flashdata('success'); ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="bg-red-500 text-white p-4 rounded-[20px] mt-4"><?= $error; ?></div>
        <?php endif; ?>
    </form>

    <!-- Tampilkan hasil jika ada -->
    <?php if ($results): ?>
        <div class="mt-8">
            <div class="mb-3">
                <h2 class="font-semibold">Mean Squared Error:</h2>
                <?php echo $results['Mean Squared Error']; ?>
            </div>
            <div class="mb-3">
                <h2 class="font-semibold">R-squared:</h2>
                <?php echo $results['R-squared']; ?>
            </div>
            <div class="mb-3 font-normal">
                <h2 class="font-semibold">Aturan Decision Tree:</h2>
                <pre><?php echo nl2br($results['Decision Tree Rules']); ?></pre>
            </div>
        </div>
    <?php endif; ?>
  </div>
</div>
