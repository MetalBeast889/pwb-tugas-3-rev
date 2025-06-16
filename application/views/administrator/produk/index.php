  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Produk Page</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Produk Page</li>
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
                <h5 class="card-title">Produk</h5>

                <p class="card-text">
                  <a href="<?= base_url('admin/produk/tambah') ?>" class = "btn btn-labeled btn-primary">
                    <span class="btn-label">
                      <i class= "fa fa-plus"></i>
                    </span>
                    Produk
                  </a>
                  <div class="card-body">
                <?php if($this->session->flashdata('message')) :?>
                  <?= $this->session->flashdata('message')?>
                <?php endif ?>           
                  </div>
                  
                <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Produk Table</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 300px;">
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>NO</th>
                      <th>Nama</th>
                      <th>Kategori</th>
                      <th>Harga</th>
                      <th>Stok</th>
                      <th>Deskripsi</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no=1;
                    foreach($list_produk as $produk):// list kategori asal dari kategori_controller
                    ?>
                    <tr>
                      <th scope="row"><?=$no ?></th>
                      <td><?=$produk['pd_nama']?></td>
                      <td><?=$produk['kt_nama'];?></td>
                      <td>Rp. <?= number_format($produk['harga'])?></td>
                      <td><?=$produk['stok'];?></td>
                      <td><?=$produk['deskripsi']?></td>
                      <td>
                        <a href="<?= base_url('admin/produk/ubah/')?><?=$produk['id_produk']?>"><span class="btn btn-success"><i class="fa fa-edit"></i> Ubah</span></a>
                        <a href="<?= base_url('admin/produk/hapus/')?><?=$produk['id_produk']?>"><span class="btn btn-danger"><i class="fa fa-trash"></i>Hapus</span></a>
                      </td>
                    </tr>
                  <?php $no++; 
                  endforeach ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </p>
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
