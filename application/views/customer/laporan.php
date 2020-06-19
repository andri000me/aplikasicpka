<div class="wrapper">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">        
                    <div class="card-body ">
                        <div class="card-title">
                            <div class="text-center">
                                <h4>Laporan Data Customer</h4>
                            </div>
                            <hr>
                        </div>
                        <form method="post" role="form" action="<?= site_url('customer/laporan_customer') ?>" target="_blank">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Dari Tanggal</label>
                                        <input type="date" name="tglAwal" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <label>Sampai Tanggal</label>
                                    <input type="date" name="tglAkhir" class="form-control" required>
                                </div>
                                <div class="col-lg-12">
                                    <div class="text-center">
                                        <button class="btn btn-sm btn-info" type="submit"><i class="fa fa-print"></i> Tampilkan</button>
                                    </div>
                                </div>
                            </div>

                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>