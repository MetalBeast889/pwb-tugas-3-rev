<div class="container mt-5">
    <h2>Profil Pelanggan</h2>
    <hr>

    <!-- Tampilkan flash message -->
    <?php if ($this->session->flashdata('message')): ?>
        <?= $this->session->flashdata('message'); ?>
    <?php endif; ?>

    <div class="text-center mb-4">
        <?php if (!empty($pelanggan['foto_profil'])): ?>
            <img src="<?= base_url('uploads/profil/' . $pelanggan['foto_profil']) ?>" 
                 alt="Foto Profil" 
                 class="rounded-circle" 
                 width="200" height="200" 
                 style="object-fit: cover;">
        <?php else: ?>
            <img src="<?= base_url('assets/dist/img/ph_profil.jpg') ?>" 
                 alt="Default Foto" 
                 class="rounded-circle" 
                 width="150" height="150" 
                 style="object-fit: cover;">
        <?php endif; ?>
    </div>

    <!-- ubah -->
    <form method="post" enctype="multipart/form-data" action="<?= base_url('profil/ubah/' . $this->session->userdata('id')) ?>">

    <tr>
        <th><b>Foto Profil</b></th>
        <td>
            <input type="file" class="form-control" name="foto_profil" accept="image/*">
            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah (Max size: 5 MB).</small>
        </td>
    </tr>

    <!-- <form method="post" action="<?= base_url('profil_controller/ubah_profil/' . $this->session->userdata('id')) ?>"> -->
        <table class="table table-bordered">
            <tr> 
                <th>Email (Tetap)</th>
                <td>
                    <input type="text" class="form-control fw-bold " name="email" value="<?= htmlspecialchars($pelanggan['email']) ?>" disabled>
                </td>             
            </tr>

            <tr> 
                <th>Password</th>
                <td>
                    <input type="password" class="form-control" name="password" value="" placeholder="Masukkan password baru / Biarkan kosong jika tidak ingin mengubah">
                    <small class="text-danger"><?= form_error('password') ?></small>
                </td>             
            </tr>

            <tr>
                <th>Nama Lengkap</th>
                <td>
                    <input type="text" class="form-control" name="nama" value="<?= set_value('nama', htmlspecialchars($pelanggan['nama_pelanggan'])) ?>">
                    <small class="text-danger"><?= form_error('nama') ?></small>
                </td>
            </tr>

            <tr>
                <th>No Telpon</th>
                <td>
                    <input type="text" class="form-control" name="nopon" value="<?= set_value('nopon', htmlspecialchars($pelanggan['telp_pelanggan'])) ?>">
                    <small class="text-danger"><?= form_error('nopon') ?></small>
                </td>
            </tr>

            <tr>
                <th>Kode POS</th>
                <td>
                    <input type="number" class="form-control" name="kodepos" value="<?= set_value('kodepos', htmlspecialchars($pelanggan['kode_pos'])) ?>">
                    <small class="text-danger"><?= form_error('kodepos') ?></small>
                </td>
            </tr>

            <tr>
                <th>Kota</th>
                <td>
                    <input type="text" class="form-control" name="kota" value="<?= set_value('kota', htmlspecialchars($pelanggan['kota'])) ?>">
                    <small class="text-danger"><?= form_error('kota') ?></small>
                </td>
            </tr>

            <tr>
                <th>Provinsi</th>
                <td>
                    <input type="text" class="form-control" name="provinsi" value="<?= set_value('provinsi', htmlspecialchars($pelanggan['provinsi'])) ?>">
                    <small class="text-danger"><?= form_error('provinsi') ?></small>
                </td>
            </tr>

            <tr>
                <th>Alamat</th>
                <td>
                    <textarea name="alamat" class="form-control" rows="4"><?= set_value('alamat', htmlspecialchars($pelanggan['alamat'])) ?></textarea>
                    <small class="text-danger"><?= form_error('alamat') ?></small>
                </td>
            </tr>
        </table>

        <button type="submit" class="btn btn-primary">
            <i class="fa fa-edit"></i> Ubah Profil
        </button>
    </form>
</div>