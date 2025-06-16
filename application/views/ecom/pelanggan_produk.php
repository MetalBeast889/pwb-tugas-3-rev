<!-- Konten Produk Berdasarkan Kategori -->
<style>
    .diskon {
        position: absolute;
        top: 8px;
        right: 16px;
    }

    .img-produk {
        width: 100%;
        aspect-ratio: 3 / 4;
        object-fit: cover;
        object-position: center;
    }
</style>

<div class="container mb-3">
    <!-- Tampilkan Judul Kategori -->
    <?php if (!empty($kategori_nama)) : ?>
        <div class="mb-4 text-center">
            <h2 class="fw-bold"> Kategori : <?=$kategori_nama?></h2>
            <hr>
        </div>
    <?php endif; ?>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
        <?php if (count($list_produk) > 0): ?>
            <?php foreach ($list_produk as $key => $value): ?>
                <div class="col">
                    <div class="card shadow-sm">
                        <?php
                        $gambar = $gambar_model->get_by_product_id($value['id_produk']);
                        ?>
                        <a href="<?= base_url('produk/').$value['id_produk']?>">
                            <img src="<?= base_url('uploads') ?>/produk/<?= $gambar[0]['nama_gambar'];?>" class="img-produk" alt="...">
                        </a>
                        <?php if (!empty($value['diskon'])): ?> 
                            <div class="diskon">
                                <span class="badge bg-success"><?= $value['diskon']['nama076']?> - <?=$value['diskon']['jumlah_diskon076']?>% OFF</span>
                            </div>
                        <?php endif; ?> 
                        <div class="card-body">
                            <a href="<?= base_url('produk/') . $value['id_produk']?>">
                                <h5 class="card-title"><?= $value['pd_nama']?></h5>
                            </a>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="harga d-flex flex-column" style="color:dark">
                                    <?php if (!empty($value['diskon'])): ?>
                                        <div>
                                            <small><del>Rp. <?= number_format($value['harga']) ?></del></small>
                                        </div>
                                        <div>
                                            <h5 style="color:red">Rp. <?= number_format($value['harga_setelah_diskon']) ?></h5>
                                        </div>
                                    <?php else: ?>
                                        <div>
                                            <h4>Rp. <?= number_format($value['harga']) ?></h4>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <small>
                                    <p>2 terjual</p>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p class="text-muted">Produk tidak ditemukan untuk kategori ini.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Tombol Lihat Semua -->
<?php if (!empty($tampilkan_lihat_semua)): ?>
    <div class="container mt-4 text-center">
        <a href="<?= base_url('produk') ?>" class="btn btn-outline-primary">Lihat Semua Produk</a>
    </div>
<?php endif; ?>

