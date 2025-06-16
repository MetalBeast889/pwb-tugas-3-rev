  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Diskon Page</h1>
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
                <h5 class="card-title"><?=$title;?></h5>

                <p class="card-text">
                  <a href="<?= base_url('admin/diskon/tambah') ?>" class = "btn btn-labeled btn-primary">
                    <span class="btn-label">
                      <i class= "fa fa-plus"></i>
                    </span>
                    Diskon
                  </a>
                  <div class="card-body">
                <?php if($this->session->flashdata('message')) :?>
                  <?= $this->session->flashdata('message')?>
                <?php endif ?>           
                  </div>
                  
                <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Diskon Table</h3>

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
                      <th>Jumlah Diskon</th>
                      <th>Nama Produk</th>
                      <th>Deskripsi</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no=1;
                    foreach($list_diskon as $diskon):// list diskon asal dari produk_diskon_controller076
                    ?>
                    <tr>
                      <td><?=$no;?></td>
                      <td><?=$diskon['nama076'];?></td>
                      <td><?=$diskon['jumlah_diskon076']?>%</td>
                      <td><?=$diskon['pd_nama']?></td>
                      <td><?=$diskon['deskripsi076'];?></td>
                      <td>
                        <a href="<?= base_url('admin/diskon/hapus/')?><?=$diskon['id_diskon076']?>"><span class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</span></a>
                      </td>
                    <?php $no++; endforeach; ?>
                    </tr>
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
