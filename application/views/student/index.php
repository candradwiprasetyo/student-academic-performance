<div class="container mx-auto mt-8">
    <div class="bg-white rounded-[20px] shadow bg-white relative w-full">
        <div class="flex items-center justify-between">
            <div class="pt-6 px-8">
                <div class="text-xl font-semibold mb-1">Data Mahasiswa</div>
                <div class="text-sm text-gray-400 text-semibold">Total <?= $total_students; ?> data</div>
            </div>
            <div class="pr-6">
                <a href="<?= base_url('student/form'); ?>" class="bg-blue-400 py-2 px-5 text-white rounded-[20px] text-sm font-bold">Tambah Data</a>
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
                        <th class="pt-8 pb-4">IPK</th>
                        <th class="pt-8 pb-4">Skor Akses Transportasi</th>
                        <th class="pt-8 pb-4">Jarak Kampus</th>
                        <!-- <th class="pt-8 pb-4">Alamat</th> -->
                        <th class="pt-8 pb-4">Tahun</th>
                        <th class="pt-8 pb-4">Kampus</th>
                        <th class="pt-8 pb-4">Area</th>
                        <th align="right" class="pt-8 pb-4 pr-8"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $nomor = 1;  
                        foreach ($students as $row): 
                    ?>
                        <tr class="border-t">
                            <td class="pl-8 py-3"><?= $nomor++; ?></td>
                            <td><?= $row->student_name; ?></td>
                            <td><?= $row->student_gpa; ?></td>
                            <td align="middle"><?= $row->student_transportation_access_score; ?></td>
                            <td><?= $row->student_distance_to_campus_km; ?></td>
                            <!-- <td><?= $row->student_address; ?></td> -->
                            <td><?= $row->student_enrollment_year; ?></td>
                            <td><?= $row->campus_name; ?></td>
                            <td>
                            <?php 
                            switch ($row->area_id) {
                                case 1:
                                    echo "Kota Besar";
                                    break;
                                case 2:
                                    echo "Pinggiran Kota";
                                    break;
                                case 3:
                                    echo "Desa";
                                    break;
                                default:
                                    echo "Tidak Diketahui";
                            }
                            ?>
                            </td>
                            <td align="right" class="pr-6">
                                <a href="<?= base_url('student/form/' . $row->student_id); ?>" class="bg-green-400 py-2 px-5 text-white rounded-l-[20px] text-sm font-bold">Edit</a>
                                <a href="<?= base_url('student/delete/' . $row->student_id); ?>" class="bg-red-400 py-2 px-5 text-white rounded-r-[20px] text-sm font-bold" onclick="return confirm('Anda yakin ingin menghapus data ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
