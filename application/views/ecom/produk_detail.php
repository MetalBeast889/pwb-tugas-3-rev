<style>
	.image-produk {
		width: 100%;
	}

	.image-nav {
		width: 100%;
		padding: 8%;
	}

	.badge-large {
	  font-size: 1.2rem;
	  font-weight: 600;
	}
</style>

    <?php if ($this->session->flashdata('message')): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
                <?= $this->session->flashdata('message'); ?>
        		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

<div class="container mb-3 mt-4">
	<div class="p-5 mb-4 bg-light rounded-3">
		<div class="container-fluid py-1 text-center">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb justify-content-center text-small">
					<li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
					<li class="breadcrumb-item"><a href="<?= base_url('kategori/' . $kategori['id_kategori']) ?>">
						<?= $kategori['nama'] ?>
					</a>
				</li>
				</ol>
			</nav>
		</div>
	</div>
<!-- 	<?php
echo '<pre>';
print_r($produk);
echo '</pre>';
?>
 -->
	<div class="row">
		<div class="col-5">
			<div class="product-slick mb-2">
				<?php foreach ($list_gambar as $gambar) : ?>
				<div><img src="<?= base_url('uploads/produk')?>/<?= $gambar['nama_gambar']?>" alt="" class="image-produk img-fluid"></div>
				<?php endforeach?>
			</div>
			<div class="row">
				<div class="col-12 p-2">
					<div class="slider-nav">
						<?php foreach ($list_gambar as $gambar) : ?>
						<div><img src="<?= base_url('uploads/produk')?>/<?= $gambar['nama_gambar']?>" alt="" class="image-nav img-fluid"></div>
						<?php endforeach?>
					</div>
				</div>
			</div>

		</div>
		<div class="col">
			<div class="produk-detail">
				<div class="pro-group">
					<h2><?= $produk['nama']?></h2>
					<?php if (!empty($produk['diskon'])): ?>
					 <span class="badge bg-success badge-large">
					  <?= $produk['diskon']['nama076']?> - <?=$produk['diskon']['jumlah_diskon076']?>% OFF
					</span>
					<div class="mt-2">
				        <h5 style="color: gray;"><del>Rp. <?= number_format($produk['harga']) ?></del></h5>
				        <h3 style="color:red">Rp. <?= number_format($produk['harga_setelah_diskon']) ?></h3>
				    <?php else: ?>
				        <h4>Rp. <?= number_format($produk['harga']) ?></h4>
				    <?php endif; ?>
					</div>
					<p>ID Produk: <?=$produk['id_produk']?></p>
					<p>STOK: <?= $produk['stok']?></p>
					<div class="produk-order mb-0">
						<h6 class="product-title">Jumlah beli</h6> 
						<form action="<?= base_url('keranjang/tambah') ?>" method="post">
						    <input type="hidden" name="id_produk" value="<?= $produk['id_produk'] ?>">
						    <div class="input-group">
						        <input class="form-control" name="jumlah" type="number" min="1" max="<?= $produk['stok'] ?>" value="1" required>
						    </div>
						    <div class="product-buttons mt-4 mb-4">
						        <button type="submit" class="btn btn-primary">
						            <i class="fa fa-shopping-cart"></i> Tambah ke Keranjang
						        </button>
						    </div>
						</form>
					</div>

					<div class="deskripsi">
						<h4>Deskripsi:</h4>
						<p><?= $produk['deskripsi']?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
  $(document).ready(function () {
    $('.product-slick').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      asNavFor: '.slider-nav'
    });
    $('.slider-nav').slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      asNavFor: '.product-slick',
      dots: true,
      centerMode: true,
      focusOnSelect: true
    });
  });
</script>

