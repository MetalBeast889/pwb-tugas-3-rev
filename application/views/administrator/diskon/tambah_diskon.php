  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tambah Diskon Page</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Diskon Page</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Tambah diskon</h5>

                <p class="card-text">
                  <form method="post">
                    <div class="mb-3">
                      <label for="nama_diskon" class="form-label">
                      Nama Diskon</label>
                      <input type="text" class="form-control" name="nama_diskon" id="nama_diskon" aria-describedby="Nama diskon"><small class="text-danger"><em><?= form_error('nama_diskon') ?></em></small>
                    </div>

                    <div class="mb-3">
                      <label for="produk" class="form-label">Diskon untuk produk
                      </label>
                      <select class="form-select" name="produk" id="produk" class="form-control" aria-describedby="Nama Produk">
                        <option value="" selected>-- pilih produk --</option>
                        <?php foreach ($list_produk as $produk) :?>
                          <option value ="<?= $produk['id_produk']?>"><?= $produk['pd_nama'] ?>
                          </option>
                      <?php endforeach ?>
                      </select>
                       <small class="text-danger"><em><?= form_error('produk') ?></em></small>
                    </div>
                    
                    <div class="mb-3">
                      <label for="nama_diskon" class="form-label">
                      Jumlah Diskon (%)</label>
                      <input type="text" class="form-control" name="jumlah_diskon" id="jumlah_diskon" aria-describedby="Jumlah diskon"><small class="text-danger"><em><?= form_error('jumlah_diskon') ?></em></small>
                    </div>
                    <div class="mb-3">
                      <label for="deskripsi_diskon" class="form-label">Deskripsi 
                      </label>
                      <textarea name="deskripsi_diskon" id="deskripsi_diskon" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                    <a href="<?= base_url('admin/diskon')?>" class="btn btn-danger">Kembali</a>
                  </form>
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
